<?php

namespace Divona\StandingsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Divona\UserBundle\Entity\User;

class Standing
{
    /* Game status */
    /**
     * Win.
     */
    const STANDING_GAME_WIN = 1;
    /**
     * Draw.
     */
    const STANDING_GAME_DRAW = 0;
    /**
     * Lost.
     */
    const STANDING_GAME_LOST = -1;

    protected $standing;

    public function __construct()
    {
        $this->standing = new ArrayCollection();
    }

    /**
     * Set standing
     *
     * @param ArrayCollection $createdAt
     */
    public function setStanding($standing)
    {
        $this->standing = $standing;
    }

    /**
     * Get standing
     *
     * @return ArrayCollection
     */
    public function getStanding()
    {
        return $this->standing;
    }

    /**
     * Add a player to the standing if not exist.
     *
     * @param User $player
     */
    public function addPlayer(User $player)
    {
        if (!$this->standing->containsKey($player->getid()))
        {
            $this->standing->set($player->getid(), array(
                'draw' => 0,
                'goalaverage' => 0,
                'lost' => 0,
                'played' => 0,
                'player' => $player,
                'points' => 0,
                'point_per_games' => 0,
                'position' => 0,
                'win' => 0,
            ));
        }
    }

    /**
     * Add a game for a player in the standing.
     *
     * @param User $player
     * @param $status
     *     game status, available status:
     *         STANDING_GAME_WIN : for a win
     *         STANDING_GAME_DRAW : for a draw
     *         STANDING_GAME_LOST : for a lost
     * @param $goalaverage (optional)
     */
    public function addPlayerGame(User $player, $status, $goalaverage = null)
    {
        if ($player_results = $this->standing->get($player->getid()))
        {
            $player_results['played']++;
            switch ($status)
            {
                case self::STANDING_GAME_WIN:
                    $player_results['win']++;
                    $player_results['points'] += 3;
                    break;
                case self::STANDING_GAME_DRAW:
                    $player_results['draw']++;
                    $player_results['points'] += 1;
                    break;
                case self::STANDING_GAME_LOST:
                    $player_results['lost']++;
                    break;
            }

            $player_results['point_per_games'] = round($player_results['points'] / $player_results['played'], 2);

            if (isset($goalaverage))
            {
                $this->addPlayerGaolaverage($player, $goalaverage);
            }

            $this->standing->set($player->getid(), $player_results);
        }
    }

    /**
     * Add goal average for a player.
     *
     * @param User $player
     * @param $goalaverage
     */
    public function addPlayerGaolaverage(User $player, $goalaverage)
    {
        if ($player_results = $this->standing->get($player->getid()))
        {
            $player_results['goalaverage'] += $goalaverage;

            $this->standing->set($player->getid(), $player_results);
        }
    }

    public function sort()
    {
        $iter = $this->standing->getIterator();
        $iter->uasort(function($a, $b) {

            if ($a['point_per_games'] > $b['point_per_games'])
            {
                return -1;
            }
            elseif ($b['point_per_games'] > $a['point_per_games'])
            {
                return 1;
            }
            else
            {
                if ($a['goalaverage'] > $b['goalaverage'])
                {
                    return -1;
                }
                elseif ($b['goalaverage'] > $a['goalaverage'])
                {
                    return 1;
                }
                else {
                    if ($a['points'] > $b['points'])
                    {
                        return -1;
                    }
                    elseif ($b['points'] > $a['points'])
                    {
                        return 1;
                    }
                    else {
                        return 0;
                    }
                }
            }
        });

        $this->standing->clear();
        $i = 1;
        foreach ($iter as $player_id => $values) {
            $values['position'] = $i;
            $this->standing->set($player_id, $values);
            $i++;
        }
    }
}