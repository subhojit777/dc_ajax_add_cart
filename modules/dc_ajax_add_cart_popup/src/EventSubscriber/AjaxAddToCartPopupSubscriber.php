<?php

namespace Drupal\dc_ajax_add_cart_popup\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Drupal\commerce_cart\Event\CartEntityAddEvent;
use Drupal\commerce_cart\Event\CartEvents;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\OpenModalDialogCommand;
use Drupal\Core\Url;
use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * Event subscriber to display a popup when items are added to cart via AJAX.
 */
class AjaxAddToCartPopupSubscriber implements EventSubscriberInterface {

  /**
   * The entity that was added to the cart.
   *
   * @var \Drupal\commerce_product\Entity\ProductVariationInterface
   */
  protected $purchasedEntity;

  /**
   * EntityTypeManager service.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new AjaxAddToCartPopupSubscriber object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   Used to display the rendered product_variation entity.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * Adds the popup confirmation message on page.
   *
   * @param \Symfony\Component\HttpKernel\Event\FilterResponseEvent $event
   *   The response event.
   */
  public function onResponse(FilterResponseEvent $event) {
    $response = $event->getResponse();

    // We only care if this happened after an entity was added to the cart.
    if (!$this->purchasedEntity) {
      return;
    }

    // We only care about AJAX responses.
    if (!$response instanceof AjaxResponse) {
      return;
    }

    // Render the status message and the entity.
    $view_builder = $this->entityTypeManager->getViewBuilder('commerce_product_variation');
    $product_variation = $view_builder->view($this->purchasedEntity, 'dc_ajax_add_to_cart_popup');
    $content = [
      '#theme' => 'dc_ajax_add_cart_popup',
      '#product_variation' => $product_variation,
      '#product_variation_entity' => $this->purchasedEntity,
      '#cart_url' => Url::fromRoute('commerce_cart.page')->toString(),
    ];
    $title = '';
    $options = ['width' => '700'];
    $response->addCommand(new OpenModalDialogCommand($title, $content, $options));
    $event->setResponse($response);
  }

  /**
   * Initializes the purchased entity.
   *
   * @param \Drupal\commerce_cart\Event\CartEntityAddEvent $event
   *   The add to cart event.
   */
  public function onAddToCart(CartEntityAddEvent $event) {
    $this->purchasedEntity = $event->getEntity();
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [
      KernelEvents::RESPONSE => 'onResponse',
      CartEvents::CART_ENTITY_ADD => 'onAddToCart',
    ];
  }

}
