<?php

namespace Anax\MyTextFilter;


/**
 * Showing off a standard class with methods and properties.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class MyTextFilterModel
{
    private $filter = [
        "markdown"  => "markdown",
    ];
    private $di;

    public function __construct($di)
    {
        $this->di = $di;
    }

    /**
     * Filter method to formate and filter a text
     *
     * @return string
     */
    public function loopText($data)
    {
            foreach ($data as $row) {
                $text = $this->filterRequest($row->content);
                $row->content = $text;
                if (isset($row->comments)) {
                    foreach ($row->comments as $comments) {
                        $text = $this->filterRequest($comments->content);
                        $comments->content = $text;
                    }
                }
            }

        return $data;
    }

    /**
     * Filter method to formate and filter a text
     *
     * @return string
     */
    public function filterRequest($data)
    {
        $textFilter = $this->di->get("textfilter");
        $text = $textFilter->parse($data, $this->filter)->text;

        return $text;
    }
}
