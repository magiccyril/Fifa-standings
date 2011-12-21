<?php
/**
 * Class to generate pagination for items
 */
namespace Divona\StandingsBundle\Helper;

class Paginator {

    //current displayed page
    protected $currentpage;
    //limit items on one page
    protected $limit;
    //total number of pages that will be generated
    protected $numpages;
    //total items loaded from database
    protected $itemscount;
    //starting item number to be shown on page
    protected $offset;

    function __construct($itemscount, $page = 1, $limit = 10) {
        //set total items count from controller
        $this->itemscount = $itemscount;

        $this->currentpage = $page;
        //If currentpage is set to 0 or less set it to 1
        if ($this->currentpage < 1) {
            $this->currentpage = 1;
        }

        $this->limit = $limit;
        // if limit is any number less than 1 then set it to 0 for displaying items without limit
        if ($this->limit < 1) {
            $this->limit = 0;
        }

        //Calculate number of pages total
        $this->getInternalNumPages();
        if ($this->currentpage > $this->numpages) {
            $this->currentpage = $this->numpages;
        }

        //Calculate first shown item on current page
        $this->calculateOffset();
    }

    public function getNumpages() {
        return $this->numpages;
    }

    public function getPageRange() {
        $range = range(1, $this->numpages);

        $offset = $this->currentpage - 3;
        if ($offset < 0) {
            $offset = 0;
        }

        $length = 5;
        $range = array_slice($range, $offset, $length);

        if (1 != $range[0]) {
            array_unshift($range, -1);
        }

        if ($range[count($range) - 1] != $this->numpages) {
            $range[] = -1;
        }

        return $range;
    }

    private function getInternalNumPages() {
        //If limit is set to 0 or set to number bigger then total items count
        //display all in one page
        if (($this->limit < 1) || ($this->limit > $this->itemscount)) {
            $this->numpages = 1;
        } else {
            //Calculate rest numbers from dividing operation so we can add one
            //more page for this items
            $restItemsNum = $this->itemscount % $this->limit;
            //if rest items > 0 then add one more page else just divide items
            //by limit
            $restItemsNum > 0 ? $this->numpages = intval($this->itemscount / $this->limit) + 1 : $this->numpages = intval($this->itemscount / $this->limit);
        }
    }

    private function calculateOffset() {
        //Calculet offset for items based on current page number
        $this->offset = ($this->currentpage - 1) * $this->limit;
    }

    public function getCurrentpage() {
        return $this->currentpage;
    }

    //For using from controller
    public function getLimit() {
        return $this->limit;
    }
    //For using from controller
    public function getOffset() {
        return $this->offset;
    }

}