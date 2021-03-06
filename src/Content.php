<?php

namespace EspressoTutorials\Epub;

use EspressoTutorials\Epub\Elements\Item;
use EspressoTutorials\Epub\Elements\ItemRef;

class Content
{
    protected SimpleXMLElement $element;

    protected array $manifest = [];

    protected array $spine = [];

    public function __construct(
        protected string $file
    ) {
        $this->element = SimpleXMLElement::fromPath($this->file);
    }

    public function manifest(): array
    {
        if ($this->manifest) {
            return $this->manifest;
        }

        foreach ($this->element->manifest->item as $node) {
            $this->manifest[] = new Item(
                (string) $node->attributes()['id'],
                dirname($this->file) . '/' . $node->attributes()['href'],
                (string) $node->attributes()['media-type'],
            );
        }

        return $this->manifest;
    }

    public function spine(): array
    {
        if ($this->spine) {
            return $this->spine;
        }

        foreach ($this->element->spine->itemref as $node) {
            $this->spine[] = new ItemRef(
                (string) $node->attributes()['idref'],
            );
        }

        return $this->spine;
    }
}
