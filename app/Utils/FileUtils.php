<?php
namespace App\Utils;

use Symfony\Component\Finder\Finder;

abstract class FileUtils
{
    /**
     * @param $path
     * @return Finder|\Symfony\Component\Finder\SplFileInfo[]
     */
    public static function getPhpFilesInDirectory($path)
    {
        if (!file_exists($path)) {
            return [];
        }

        return Finder::create()
            ->files()
            ->depth(0)
            ->name('*.php')
            ->in($path);
    }
}