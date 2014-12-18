<?php
/*!
 * Ascension
 * Copyright 2014 Jack Polgar
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Ascension;

use Radium\Application;
use Radium\Templating\View;
use Radium\Templating\Engines\PhpEngine;
use Radium\Templating\Engines\TwigEngine;
use Radium\Templating\Engines\DelegationEngine;
use Avalon\Database\ConnectionManager;

class Kernel extends Application
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Custom database connection.
     *
     * We need to connect to the sites database as well as the forums database.
     */
    protected function connectDatabase()
    {
        $this->databaseConnection = ConnectionManager::create($this->databaseConfig);
    }

    /**
     * Configure custom templating options.
     */
    protected function configureTemplating()
    {
        $twigEngine = new TwigEngine;

        // Register helpers
        $twig = $twigEngine->getTwig();
        $twig->addExtension(new \Radium\Templating\TwigExtensions\Language);
        $twig->addExtension(new \Radium\Templating\TwigExtensions\HTML);
        $twig->addExtension(new \Radium\Templating\TwigExtensions\Form);
        $twig->addExtension(new \Radium\Templating\TwigExtensions\URL);
        $twig->addExtension(new \Radium\Templating\TwigExtensions\Assets);
        $twig->addExtension(new \Radium\Templating\TwigExtensions\Time);
        $twig->addExtension(new \Radium\Templating\TwigExtensions\TWBS);

        // Use Twig and PHP engines
        View::setEngine(new DelegationEngine([
            $twigEngine,
            new PhpEngine
        ]));

        // Add view path to engines
        View::addPath("{$this->path}/views");
    }
}
