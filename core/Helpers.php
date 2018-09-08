<?php

namespace JRC\Core;
/**
 * 
 */
final class Helpers
{
	public function get_date($date)
	{
		$timestamp = strtotime($date);
        if (date('dmy', $timestamp) == date('dmy')) {
            return 'Сегодня в ' . date('H:i', $timestamp);
        } elseif (date('dmy', $timestamp) == date('dmy', time()-86400)) {
            return 'Вчера в ' . date('H:i', $timestamp);
        } else {
            return date('d/m/Y - H:i', $timestamp);
        }
	}

	public function text_cut($text, $lenght)
    {
      return mb_strlen($text) > $lenght ?
        mb_substr($text, 0, $lenght) . '...' :
        $text;
    }
}