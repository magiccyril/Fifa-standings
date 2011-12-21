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
    const STANDING_GAME_WIN = 3;
    /**
     * Draw.
     */
    const STANDING_GAME_DRAW = 1;
    /**
     * Lost.
     */
    const STANDING_GAME_LOST = 0;

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
                'goal_conceded' => 0,
                'goal_difference' => 0,
                'goal_scored' => 0,
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
     * @param $goal_scored
     * @param $goal_conceded
     */
    public function addPlayerGame(User $player, $goal_scored, $goal_conceded)
    {
        // Get results for this player.
        $player_results = $this->standing->get($player->getid());

        // If player not exist, then add it.
        if (!$player_results) {
            $this->addPlayer($player);
            $player_results = $this->standing->get($player->getid());
        }

        $player_results['played']++;
        $player_results['goal_conceded'] += $goal_conceded;
        $player_results['goal_scored'] += $goal_scored;
        $player_results['goal_difference'] = $player_results['goal_scored'] - $player_results['goal_conceded'];

        // win
        if ($goal_scored > $goal_conceded)
        {
            $player_results['win']++;
            $player_results['points'] += self::STANDING_GAME_WIN;
        }
        // lost
        elseif ($goal_conceded > $goal_scored)
        {
            $player_results['lost']++;
            $player_results['points'] += self::STANDING_GAME_LOST;
        }
        // draw
        else {
            $player_results['draw']++;
            $player_results['points'] += self::STANDING_GAME_DRAW;
        }

        // Calculate point per games.
        $player_results['point_per_games'] = round($player_results['points'] / $player_results['played'], 2);

        // Save the results for this player.
        $this->standing->set($player->getid(), $player_results);
    }

    public function sort()
    {
        $iter = $this->standing->getIterator();
        $iter->uasort(function($a, $b) {

            // first check points per game.
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
                // then goal difference.
                if ($a['goal_difference'] > $b['goal_difference'])
                {
                    return -1;
                }
                elseif ($b['goal_difference'] > $a['goal_difference'])
                {
                    return 1;
                }
                // then points.
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