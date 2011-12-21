<?php

namespace Divona\StandingsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class GameType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('player1')
            ->add('player2')
            ->add('score_player1')
            ->add('score_player2')
        ;
    }

    public function getName()
    {
        return 'divona_standingsbundle_gametype';
    }
}
