<?php


namespace App\Service;


class Slugify
{
    public function generate(string $input): string
    {
        $utf8 = array(
            '/[áàâãªäåæ]/u' => 'a',
            '/[ÁÀÂÃÄÅÆ]/u' => 'A',
            '/[éèêë]/u' => 'e',
            '/[ÉÈÊË]/u' => 'E',
            '/[ÍÌÎÏÍ]/u' => 'I',
            '/[íìîï]/u' => 'i',
            '/[óòôõºöðø]/u' => 'o',
            '/[ÓÒÔÕÖØ]/u' => 'O',
            '/[úùûü]/u' => 'u',
            '/[ÚÙÛÜ]/u' => 'U',
            '/[ýýÿ]/u' => 'y',
            '/Š/u' => 'S',
            '/š/u' => 's',
            '/ç/' => 'c',
            '/Ç/' => 'C',
            '/Ð/' => 'Dj',
            '/ñ/' => 'n',
            '/Ñ/' => 'N',
            '/Ý/' => 'Y',
            '/Ž/' => 'Z',
            '/ž/' => 'z',
            '/þ/' => 'b',
            '/Þ/' => 'B',
            '/ƒ/' => 'f',
            '/ß/' => 'ss',
            '/Œ/' => 'Oe',
            '/œ/' => 'oe',
            '/[!?.\']/' => '',
            '/–/' => '-', // conversion d'un tiret UTF-8 en un tiret simple
            '/[‘’‚‹›]/u' => ' ', // guillemet simple
            '/[“”«»„]/u' => ' ', // guillemet double
            '/ /' => ' ', // espace insécable (équiv. à 0x160)
        );
        $text = preg_replace(array_keys($utf8), array_values($utf8), $input);
        $slug = trim(strtolower(str_replace(' ', '-', $text)))  ;
        return $slug;
    }
}