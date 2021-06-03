<?php

declare(strict_types=1);

namespace StatusLib;

/**
 * Laminas module
 */
class Module
{
    /**
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}
