<?php

namespace Junxwan;

use Symfony\Component\Finder\Finder;

class Compiler
{
    /**
     * @var \Phar
     */
    private $phar;

    /**
     * Compiler constructor.
     *
     * @param string $pharName
     */
    public function __construct($pharName)
    {
        if (file_exists($pharName)) {
            unlink($pharName);
        }

        $this->phar = new \Phar($pharName, 0, $pharName);
        $this->phar->setSignatureAlgorithm(\Phar::SHA1);
    }

    /**
     * compiler to phar
     *
     * @return bool
     */
    public function compiler()
    {
        $this->phar->startBuffering();

        $this->addSource();
        $this->addVendor();
        $this->addRenameBin();

        $this->addFile(new \SplFileInfo(__DIR__ . '/../vendor/autoload.php'));

        $result = $this->phar->setStub($this->getStub());

        $this->phar->stopBuffering();

        return $result;
    }

    /**
     * add source file to phar
     */
    private function addSource()
    {
        $finder = new Finder();
        $finder->files()
            ->ignoreVCS(true)
            ->name('*.php')
            ->notName('compiler.php')
            ->in(__DIR__ . '/../src');

        foreach ($finder as $file) {
            $this->addFile($file);
        }
    }

    /**
     * add composer vendor file to phar
     */
    private function addVendor()
    {
        $finder = new Finder();
        $finder->files()
            ->ignoreVCS(true)
            ->name('*.php')
            ->name('LICENSE')
            ->exclude('Tests')
            ->exclude('tests')
            ->in(__DIR__ . '/../vendor/');

        foreach ($finder as $file) {
            $this->addFile($file);
        }
    }

    /**
     * add rename bin
     */
    private function addRenameBin()
    {
        $content = file_get_contents(__DIR__ . '/../bin/rename');
        $content = preg_replace('{^#!/usr/bin/env php\s*}', '', $content);
        $this->phar->addFromString('/bin/rename', $content);
    }

    /**
     * add phar file
     *
     * @param \Symfony\Component\Finder\SplFileInfo|\SplFileInfo $file
     */
    private function addFile($file)
    {
        $this->phar->addFromString(
            $this->getRelativeFilePath($file),
            $this->stripWhitespace(file_get_contents($file))
        );
    }

    /**
     * get file relative path
     *
     * @param \Symfony\Component\Finder\SplFileInfo $file
     *
     * @return string
     */
    private function getRelativeFilePath($file)
    {
        $realPath   = $file->getRealPath();
        $pathPrefix = dirname(__DIR__) . DIRECTORY_SEPARATOR;

        $pos          = strpos($realPath, $pathPrefix);
        $relativePath = ($pos !== false) ? substr_replace($realPath, '', $pos, strlen($pathPrefix)) : $realPath;

        return strtr($relativePath, '\\', '/');
    }

    /**
     * removes whitespace from a PHP source string while preserving line numbers.
     *
     * @param string $source
     *
     * @return string
     */
    private function stripWhitespace($source)
    {
        $output = '';
        foreach (token_get_all($source) as $token) {
            if (is_string($token)) {
                $output .= $token;
            } else if (in_array($token[0], [T_COMMENT, T_DOC_COMMENT])) {
                $output .= str_repeat("\n", substr_count($token[1], "\n"));
            } else if (T_WHITESPACE === $token[0]) {
                // reduce wide spaces
                $whitespace = preg_replace('{[ \t]+}', ' ', $token[1]);
                // normalize newlines to \n
                $whitespace = preg_replace('{(?:\r\n|\r|\n)}', "\n", $whitespace);
                // trim leading spaces
                $whitespace = preg_replace('{\n +}', "\n", $whitespace);
                $output     .= $whitespace;
            } else {
                $output .= $token[1];
            }
        }

        return $output;
    }

    /**
     * get phar default run php file
     *
     * @return string
     */
    private function getStub()
    {
        $stub = <<<'EOF'
#!/usr/bin/env php
<?php
if (extension_loaded('apc') && ini_get('apc.enable_cli') && ini_get('apc.cache_by_default')) {
    if (version_compare(phpversion('apc'), '3.0.12', '>=')) {
        ini_set('apc.cache_by_default', 0);
    } else {
        fwrite(STDERR, 'Warning: APC <= 3.0.12 may cause fatal errors when running composer commands.'.PHP_EOL);
        fwrite(STDERR, 'Update APC, or set apc.enable_cli or apc.cache_by_default to 0 in your php.ini.'.PHP_EOL);
    }
}

EOF;

        return $stub . <<<'EOF'
require 'phar://rename.phar/bin/rename';

__HALT_COMPILER();
EOF;
    }
}
