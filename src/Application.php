<?php

namespace Mkroese\RecipeBook;

class Application {

  protected $name;

  public function __construct($name = "Meindert-Jan's Recipe Book", $version = null) {
    $this->name = $name;
    if($version) $this->parseVersion($version);
  }

  public function getName()
  {
    return $this->name;
  }

  protected $versionParts, $fullVersion;

  protected function parseVersion($version = null) {
    if(!$version) {
      $version = `git describe --tags --always`;
    }
    $this->fullVersion = $version;

    $this->versionParts = ["major" => 0, "minor" => 0, "patch" => 0, "prerelease" => "", "build" => ""];

    if(preg_match('/^v?(\d+)\.(\d+)\.(\d+)-?([^+]*)+?(.*)$/',$this->fullVersion, $matches)) {
      $versionParts["major"] = $matches[1];
      $versionParts["minor"] = $matches[2];
      $versionParts["patch"] = $matches[3];
      $versionParts["prerelease"] = $matches[4];
      $versionParts["build"] = $matches[5];
    }
    else {
      $versionParts["build"] = $this->fullVersion;
    }
  }

  public function getFullVersion() {
    if(!$this->fullVersion) {
      $this->parseVersion();
    }
    return $this->fullVersion;
  }

  public function getVersionPart($part) {
    if(!$this->versionParts) {
      $this->parseVersion();
    }

    if(array_key_exists($part, $this->versionParts)) {
      return $this->versionParts[$part];
    }

    throw new \InvalidArgumentException("part must be one of " . var_export(array_keys($this->versionParts), true));
  }

}
