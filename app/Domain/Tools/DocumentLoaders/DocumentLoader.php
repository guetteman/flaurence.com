<?php

namespace App\Domain\Tools\DocumentLoaders;

/**
 * DocumentLoader.
 *
 * @template T
 */
abstract class DocumentLoader
{
    /**
     * Load the documents.
     *
     * @return T
     */
    abstract public function load();
}
