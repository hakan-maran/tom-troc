<?php

namespace TomTroc\Service;

use DateTime;

/**
 * Class Utils
 * A utility class providing common helper functions.
 */
class Utils
{
    /**
     * Redirect to a specified action.
     * @todo Will be in Response class
     * @param string $action The action to redirect to.
     */
    public static function redirect(string $action): void
    {
        header("Location: index.php?action=$action");
        exit();
    }
    /**
     * Check if the user is connected.
     * @todo Will be in Session class
     * @return bool
     */
    public static function isUserConnected(): bool
    {
        // Check if the user is connected by verifying if the 'user_id' session variable is set.
        return isset($_SESSION['user_id']);
    }

    /**
     * Format a date with a relative time description.
     * @param mixed $date The date to format.
     * @return string
     */
    public static function format($date): string
    {
        if ($date === null) {
            return "";
        }

        if ($date instanceof DateTime) {
            $dateTime = $date;
        } else {
            $dateTime = new DateTime($date);
        }

        $now = new DateTime();
        $interval = $now->diff($dateTime);

        /** @todo This is the bad way to do that, imagine multilanguage application.... */
        if ($interval->y >= 1) {
            return $interval->y . ' an' . ($interval->y > 1 ? 's' : '');
        } elseif ($interval->m >= 1) {
            return $interval->m . ' mois';
        }

        return "moins d'1 mois";
    }

    /**
     * Trim a string and return it.
     * @param string $string The string to trim.
     * @return string
     */
    public static function trim($string): string
    {
        if (!empty($string)) {
            return trim($string);
        }
        return "";
    }
}
