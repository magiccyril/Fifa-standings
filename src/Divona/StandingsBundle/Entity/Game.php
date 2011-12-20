<?php

namespace Divona\StandingsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Divona\StandingsBundle\Repository\GameRepository")
 * @ORM\Table(name="game")
 */
class Game
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="player1_id", referencedColumnName="id")
     */
    protected $player1;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="player2_id", referencedColumnName="id")
     */
    protected $player2;

    /**
     * @ORM\Column(type="integer")
     */
    protected $score_player1;

    /**
     * @ORM\Column(type="integer")
     */
    protected $score_player2;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created_at;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set score_player1
     *
     * @param integer $scorePlayer1
     */
    public function setScorePlayer1($scorePlayer1)
    {
        $this->score_player1 = $scorePlayer1;
    }

    /**
     * Get score_player1
     *
     * @return integer
     */
    public function getScorePlayer1()
    {
        return $this->score_player1;
    }

    /**
     * Set score_player2
     *
     * @param integer $scorePlayer2
     */
    public function setScorePlayer2($scorePlayer2)
    {
        $this->score_player2 = $scorePlayer2;
    }

    /**
     * Get score_player2
     *
     * @return integer
     */
    public function getScorePlayer2()
    {
        return $this->score_player2;
    }

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    }

    /**
     * Get created_at
     *
     * @return datetime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set player1
     *
     * @param Divona\StandingsBundle\Entity\User $player1
     */
    public function setPlayer1(\Divona\StandingsBundle\Entity\User $player1)
    {
        $this->player1 = $player1;
    }

    /**
     * Get player1
     *
     * @return Divona\StandingsBundle\Entity\User
     */
    public function getPlayer1()
    {
        return $this->player1;
    }

    /**
     * Set player2
     *
     * @param Divona\StandingsBundle\Entity\User $player2
     */
    public function setPlayer2(\Divona\StandingsBundle\Entity\User $player2)
    {
        $this->player2 = $player2;
    }

    /**
     * Get player2
     *
     * @return Divona\StandingsBundle\Entity\User
     */
    public function getPlayer2()
    {
        return $this->player2;
    }
}