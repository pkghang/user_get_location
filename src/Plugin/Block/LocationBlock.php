<?php

namespace Drupal\user_get_location\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\user_get_location\GetTimeFormTimeZoneService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a location block displaying time zone information.
 *
 * @Block(
 *   id = "location_block",
 *   admin_label = @Translation("Location Time Zone block"),
 * )
 */
class LocationBlock extends BlockBase implements ContainerFactoryPluginInterface {
  /**
   * The time zone service.
   *
   * @var \Drupal\location\GetTimeFormTimeZoneService
   */
  protected $timezoneService;

  /**
   * Constructs a new LocationBlock object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The current user.
   * @param \Drupal\user_get_location\GetTimeFormTimeZoneService $timezone_service
   *   The time zone service.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, AccountInterface $account, GetTimeFormTimeZoneService $timezone_service) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->account = $account;
    $this->timezoneService = $timezone_service;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_user'),
      $container->get('user_get_location.timezone')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $block = [];

    $country = \Drupal::config('user_get_location.settings')->get('country');
    $city = \Drupal::config('user_get_location.settings')->get('city');
    $timezone = \Drupal::config('user_get_location.settings')->get('timezone');
    if ($timezone) {
      $dateTime = $this->timezoneService->getTime($timezone);

      $block = [
          '#theme' => 'location_block',
          '#attributes' => [
            'class' => ['location_block'],
          ],
          '#country' => $country,
          '#city' => $city,
          '#timezone' => $timezone,
          '#dateTime' => $dateTime
        ];
    }
    $build[] = $block;
    $build['#cache']['max-age'] = 0;

    return $build;
  }

  /**
   * {@inheritdoc}
   */
  protected function blockAccess(AccountInterface $account) {
    return AccessResult::allowedIfHasPermission($account, 'access content');
  }

}
