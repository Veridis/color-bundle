<?php

namespace Veridis\ColorBundle\Form\DataTransformer;

use MikeAlmond\Color\Color;
use Symfony\Component\Form\DataTransformerInterface;

class ColorTransformer implements DataTransformerInterface
{
    /**
     * {@inheritdoc}
     */
    public function transform($data)
    {
        if (null === $data) {
            return null;
        }

        if ($data instanceof Color) {
            return $data->getHex();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($value)
    {
        return Color::fromHex($value);
    }
}
