<?php

namespace Drupal\user_get_location;

/**
 * Provides a service for getting time based on a given timezone.
 */
class GetTimeFormTimeZoneService {

  /**
   * Constructs a new GetTimeFormTimeZoneService object.
   */
  public function __construct() {
    // Constructor with no dependencies.
  }

  /**
   * Returns the current time formatted based on the given timezone.
   *
   * @param string $timezone
   *   The timezone identifier (e.g., 'America/New_York').
   *
   * @return string
   *   The formatted time (e.g., '15th September 2023, 03:30:45 PM').
   */
  public function getTime($timezone) {
    $date = new \DateTime("now", new \DateTimeZone($timezone));
    $formattedTime = $date->format('jS F Y, h:i:s A');
    return $formattedTime;
  }

}
