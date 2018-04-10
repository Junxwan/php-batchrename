<?php

namespace Junxwan;

use Symfony\Component\Finder\Finder;

class Rename
{
    /**
     * @var Finder
     */
    private $file;

    /**
     * @var string
     */
    private $path;

    /**
     * Rename constructor.
     *
     * @param string $path
     */
    public function __construct($path)
    {
        $this->file = $this->loadFile($path);
        $this->path = $path;
    }

    /**
     * loaded file
     *
     * @return Finder
     */
    public function file()
    {
        return $this->file;
    }

    /**
     * load file according to path
     *
     * @param string $path
     *
     * @return Finder
     */
    private function loadFile($path)
    {
        return Finder::create()->files()->in($path);
    }
}
