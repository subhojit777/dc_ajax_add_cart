<?php

namespace Drupal\Tests\dc_ajax_add_cart\Kernel;

use Drupal\Tests\commerce\Kernel\CommerceKernelTestBase;
use Drupal\dc_ajax_add_cart\RefreshPageElementsHelper;
use Drupal\Core\Ajax\AjaxResponse;

/**
 * Tests RefreshPageElementsHelper methods.
 *
 * @ingroup dc_ajax_add_cart
 *
 * @group dc_ajax_add_cart
 */
class RefreshPageElementsHelperTest extends CommerceKernelTestBase {

  /**
   * Modules to install.
   *
   * @var array
   */
  public static $modules = [
    'block',
    'commerce_order',
    'dc_ajax_add_cart',
    'entity_reference_revisions',
    'profile',
    'state_machine',
  ];

  /**
   * The block storage.
   *
   * @var \Drupal\Core\Config\Entity\ConfigEntityStorageInterface
   */
  protected $controller;

  /**
   * Active theme name.
   *
   * @var \Drupal\Core\Theme\ThemeManagerInterface
   */
  protected $activeTheme;

  /**
   * Ajax command names expected to be present in ajax response.
   *
   * @var array
   */
  protected $expectedAjaxCommandNames = [
    'remove',
    'insert',
  ];

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();

    $this->controller = $this->container->get('entity_type.manager')->getStorage('block');
    $this->activeTheme = $this->container->get('theme.manager')->getActiveTheme();
  }

  /**
   * Tests ajax response when status messages block is placed.
   */
  public function testAjaxResponseStatusMessagesBlock() {
    // Place status messages block.
    $entity = $this->controller->create([
      'id' => "{$this->activeTheme->getName()}_messages",
      'theme' => $this->activeTheme->getName(),
      'region' => 'content',
      'plugin' => 'system_messages_block',
    ]);
    $entity->save();

    $response = RefreshPageElementsHelper::updateStatusMessages(new AjaxResponse());
    $this->assertTrue($response instanceof AjaxResponse, 'Ajax response is not returned.');

    // Check if the returned response has the expected ajax commands.
    $ajax_commands = $response->getCommands();
    $actual_ajax_command_names = array_map(function ($i) {
      return $i['command'];
    }, $ajax_commands);

    foreach ($this->expectedAjaxCommandNames as $ajax_command_name) {
      $this->assertTrue(in_array($ajax_command_name, $actual_ajax_command_names), "$ajax_command_name is not present");
    }
  }

}
