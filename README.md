# php-batchrename

批次修改檔名，如有三個檔案名為`test1.txt` `test2.txt` `test3.txt`
如更名為`name` 則為改為`name-1.txt` `name-2.txt` `name-3.txt`
`name`為檔案名稱前綴`-`是分隔號加上流水號

## 使用
- 使用 bin                                

```
php bin/rename rename <檔案名> <檔案路徑>
```

- 使用 phar

```
php bin/rename.phar rename <檔案名> <檔案路徑>
```

## License

MIT
