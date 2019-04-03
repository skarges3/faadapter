<?php
/**
 * faadapter plugin for Craft CMS 3.x
 *
 * A plugin to get form assembly forms into templates.
 *
 * @link      eskargeaux.co
 * @copyright Copyright (c) 2019 Spencer Karges
 */

namespace skarges3\faadapter;

use skarges3\faadapter\variables\FaadapterVariable;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\web\twig\variables\CraftVariable;

use yii\base\Event;

/**
 * Class Faadapter
 *
 * @author    Spencer Karges
 * @package   Faadapter
 * @since     1.0.0
 *
 */
class Faadapter extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var Faadapter
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('faadapter', FaadapterVariable::class);
            }
        );

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                }
            }
        );

        Craft::info(
            Craft::t(
                'faadapter',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );

    }

    // Protected Methods
    // =========================================================================

}
