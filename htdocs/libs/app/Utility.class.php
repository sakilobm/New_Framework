<?php
class Utility
{

    public static function getDayContext($date)
    {
        $today = new DateTime();
        $targetDate = new DateTime($date);

        $diff = $today->diff($targetDate)->days;

        if ($diff == 0) {
            return 'today';
        } elseif ($diff == 1) {
            return 'tomorrow';
        } elseif ($diff == -1) {
            return 'yesterday';
        } else {
            return 'other';
        }
    }

    public static function getSectionTitle($date)
    {
        // '2024-08-18'
        $context = self::getDayContext($date);

        switch ($context) {
            case 'today':
                $headerTitle = "Today is also...";
                $subTitle = "See what else is going on today";
                break;
            case 'tomorrow':
                $headerTitle = "Tomorrow is also...";
                $subTitle = "See what's coming up tomorrow";
                break;
            case 'yesterday':
                $headerTitle = "Yesterday was also...";
                $subTitle = "See what happened yesterday";
                break;
            default:
                $headerTitle = "Also on...";
                $subTitle = "See other events";
                break;
        }
    }

    public static function recursiveHtmlEntityDecode($content)
    {
        $decoded = html_entity_decode($content);

        if ($decoded === $content) {
            return $decoded;
        }

        return self::recursiveHtmlEntityDecode($decoded);
    }
}
