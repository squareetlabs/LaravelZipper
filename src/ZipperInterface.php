<?php

namespace SquareetLabs\Zipper;


use Exception;
use Illuminate\Filesystem\Filesystem;
use InvalidArgumentException;
use RuntimeException;
use SquareetLabs\Zipper\Repositories\RepositoryInterface;

/**
 * This Zipper class is a wrapper around the ZipArchive methods with some handy functions
 *
 * Class Zipper
 */
interface ZipperInterface
{
    /**
     * Create a new zip Archive if the file does not exists
     * opens a zip archive if the file exists
     *
     * @param $pathToFile string The file to open
     * @param RepositoryInterface|string $type The type of the archive, defaults to zip, possible are zip, phar
     *
     * @return $this Zipper instance
     * @throws Exception
     * @throws InvalidArgumentException
     *
     * @throws RuntimeException
     */
    public function make(string $pathToFile, $type = 'zip'): ZipperInterface;

    /**
     * Create a new zip archive or open an existing one
     *
     * @param $pathToFile
     *
     * @return $this
     * @throws Exception
     *
     */
    public function zip($pathToFile): ZipperInterface;

    /**
     * Create a new phar file or open one
     *
     * @param $pathToFile
     *
     * @return $this
     * @throws Exception
     *
     */
    public function phar($pathToFile): ZipperInterface;

    /**
     * Create a new rar file or open one
     *
     * @param $pathToFile
     *
     * @return $this
     * @throws Exception
     *
     */
    public function rar($pathToFile): ZipperInterface;

    /**
     * Extracts the opened zip archive to the specified location <br/>
     * you can provide an array of files and folders and define if they should be a white list
     * or a black list to extract. By default this method compares file names using "string starts with" logic
     *
     * @param $path string The path to extract to
     * @param array $files An array of files
     * @param int $methodFlags The Method the files should be treated
     *
     * @throws Exception
     */
    public function extractTo(string $path, array $files = [], int $methodFlags = 2);

    /**
     * Extracts matching files/folders from the opened zip archive to the specified location.
     *
     * @param string $extractToPath The path to extract to
     * @param string $regex regular expression used to match files. See @link http://php.net/manual/en/reference.pcre.pattern.syntax.php
     *
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function extractMatchingRegex(string $extractToPath, string $regex);

    /**
     * Gets the content of a single file if available
     *
     * @param $filePath string The full path (including all folders) of the file in the zip
     *
     * @return mixed returns the content or throws an exception
     * @throws Exception
     *
     */
    public function getFileContent(string $filePath);

    /**
     * Add one or multiple files to the zip.
     *
     * @param $pathToAdd array|string An array or string of files and folders to add
     * @param null|mixed $fileName
     *
     * @return $this Zipper instance
     */
    public function add($pathToAdd, $fileName = null): ZipperInterface;

    /**
     * Add an empty directory
     *
     * @param $dirName
     *
     * @return ZipperInterface
     */
    public function addEmptyDir($dirName): ZipperInterface;

    /**
     * Add a file to the zip using its contents
     *
     * @param $filename string The name of the file to create
     * @param $content string The file contents
     *
     * @return $this Zipper instance
     */
    public function addString(string $filename, string $content): ZipperInterface;

    /**
     * Gets the status of the zip.
     *
     * @return string The status of the internal zip file
     */
    public function getStatus(): string;

    /**
     * Remove a file or array of files and folders from the zip archive
     *
     * @param $fileToRemove array|string The path/array to the files in the zip
     *
     * @return $this Zipper instance
     */
    public function remove($fileToRemove): ZipperInterface;

    /**
     * Returns the path of the current zip file if there is one.
     *
     * @return string The path to the file
     */
    public function getFilePath(): string;

    /**
     * Sets the password to be used for decompressing
     *
     * @param $password
     *
     * @return bool
     */
    public function usePassword($password): bool;

    /**
     * Closes the zip file and frees all handles
     */
    public function close();

    /**
     * Sets the internal folder to the given path.<br/>
     * Useful for extracting only a segment of a zip file.
     *
     * @param $path
     *
     * @return $this
     */
    public function folder($path): ZipperInterface;

    /**
     * Resets the internal folder to the root of the zip file.
     *
     * @return $this
     */
    public function home(): ZipperInterface;

    /**
     * Deletes the archive file
     */
    public function delete();

    /**
     * Get the type of the Archive
     *
     * @return string
     */
    public function getArchiveType(): string;

    /**
     * Get the current internal folder pointer
     *
     * @return string
     */
    public function getCurrentFolderPath(): string;

    /**
     * Checks if a file is present in the archive
     *
     * @param $fileInArchive
     *
     * @return bool
     */
    public function contains($fileInArchive): bool;

    /**
     * @return RepositoryInterface
     */
    public function getRepository(): RepositoryInterface;

    /**
     * @return Filesystem
     */
    public function getFileHandler(): Filesystem;

    /**
     * Gets the path to the internal folder
     *
     * @return string
     */
    public function getInternalPath(): string;

    /**
     * List all files that are within the archive
     *
     * @param string|null $regexFilter regular expression to filter returned files/folders. See @link http://php.net/manual/en/reference.pcre.pattern.syntax.php
     *
     * @throws  RuntimeException
     *
     * @return array
     */
    public function listFiles(string $regexFilter = null): array;
}