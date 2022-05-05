<?php

namespace SonsOfPHP\Bard;

use SonsOfPHP\Component\Json\Json;

/**
 * @author Joshua Estes <joshua@sonsofphp.com>
 */
final class JsonFile
{
    private string $filename;
    private array $config = [];
    private Json $json;

    /**
     * @param string $filename
     */
    public function __construct(string $filename)
    {
        $this->filename = $filename;
        $this->json     = new Json();
        $this->config   = $this->json->getDecoder()->objectAsArray()->decode(file_get_contents($filename));
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @param string $section
     *
     * @return null|array|int|string
     */
    public function getSection(string $section)
    {
        if (isset($this->config[$section])) {
            return $this->config[$section];
        }

        return null;
    }

    public function setSection(string $section, $value): JsonFile
    {
        $clone = clone $this;
        $clone->config[$section] = $value;

        return $clone;
    }

    /**
     */
    public function toJson(): string
    {
        return $this->json->getEncoder()
            ->prettyPrint()
            ->unescapedUnicode()
            ->unescapedSlashes()
            ->encode($this->config);
    }

    /**
     * The idea is something like this
     * $newRootComposerJsonFile = $rootComposerJsonFile->with($updateReplaceSection, $pkgComposerJsonFile);
     * or
     * $newRootComposerJsonFile = $rootComposerJsonFile->with($bumpBranchAlias);
     *
     * Can even use this for the package composer.json file
     * $newPkgComposerJsonFile = $pkgComposerJsonFile->with($updateSupportSection, $rootComposerJsonFile);
     */
    public function with(/* ComposerJsonFileManipulatorInterface */$operator, ?JsonFile $composerJsonFile = null): JsonFile
    {
        return $operator->apply($this, $composerJsonFile);
    }
}
