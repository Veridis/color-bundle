<?php

namespace Veridis\ColorBundle\Twig\Extension;

use MikeAlmond\Color\Color;
use MikeAlmond\Color\Exceptions\InvalidColorException;

class ColorExtension extends \Twig_Extension
{
    protected $defaultMode;

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('toHex', array($this, 'toHex')),
            new \Twig_SimpleFilter('toRgb', array($this, 'toRgb')),
            new \Twig_SimpleFilter('toHsl', array($this, 'toHsl')),
            new \Twig_SimpleFilter('darken', array($this, 'darken')),
            new \Twig_SimpleFilter('lighten', array($this, 'lighten')),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('color', array($this, 'color')),
        );
    }

    /**
     * @param string|array $color
     * @param string $mode
     *
     * @return Color
     */
    public function color($color, $mode = null)
    {
        // Set mode to default mode
        if (null === $mode) {
            $mode = $this->defaultMode;
        }

        if ('hex' === $mode) {
            if (!is_string($color)) {
                throw new InvalidColorException('The hex value must be a string');
            }

            return Color::fromHex($color);
        }
        if ('css' === $mode || 'csscolor' === $mode) {
            if (!is_string($color)) {
                throw new InvalidColorException('The hex value must be a string');
            }

            return Color::fromCssColor($color);
        }
        if ('rgb' === $mode) {
            if (!is_array($color) || array('r', 'g', 'b') !== array_keys($color)) {
                throw new InvalidColorException('The RGB value must be an array with "r", "g", "b" keys');
            }

            return Color::fromRgb($color['r'], $color['g'], $color['b']);
        }
        if ('hsl' === $mode) {
            if (!is_array($color) || array('h', 's', 'l') !== array_keys($color)) {
                throw new InvalidColorException('The HSL value must be an array with "h", "s", "l" keys');
            }

            return Color::fromHsl($color['h'], $color['s'], $color['l']);
        }

        throw new \InvalidArgumentException('The color mode must be "hex", "css", "csscolor", "rgb" or "hsl"');
    }

    /**
     * @param Color $color
     *
     * @return string
     */
    public function toHex(Color $color)
    {
        return $color->getHex();
    }

    /**
     * @param Color $color
     *
     * @return \int[]
     */
    public function toRgb(Color $color)
    {
        return $color->getRgb();
    }

    /**
     * @param Color $color
     *
     * @return array
     */
    public function toHsl(Color $color)
    {
        return $color->getHsl();
    }

    /**
     * @param Color $color
     * @param $percent
     *
     * @return Color
     */
    public function darken(Color $color, $percent)
    {
        return $color->darken($percent);
    }

    /**
     * @param Color $color
     * @param $percent
     *
     * @return Color
     */
    public function lighten(Color $color, $percent)
    {
        return $color->lighten($percent);
    }

    /**
     * @param array $config
     */
    public function setDefaultColorOptions(array $config)
    {
        $this->defaultMode = $config['default_color_mode'];
    }
}
