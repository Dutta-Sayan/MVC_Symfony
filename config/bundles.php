<?php

return [
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => TRUE],
    Doctrine\Bundle\DoctrineBundle\DoctrineBundle::class => ['all' => TRUE],
    Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle::class => ['all' => TRUE],
    Symfony\Bundle\DebugBundle\DebugBundle::class => ['dev' => TRUE],
    Symfony\Bundle\TwigBundle\TwigBundle::class => ['all' => TRUE],
    Symfony\Bundle\WebProfilerBundle\WebProfilerBundle::class => ['dev' => TRUE, 'test' => TRUE],
    Symfony\UX\StimulusBundle\StimulusBundle::class => ['all' => TRUE],
    Symfony\UX\Turbo\TurboBundle::class => ['all' => TRUE],
    Twig\Extra\TwigExtraBundle\TwigExtraBundle::class => ['all' => TRUE],
    Symfony\Bundle\SecurityBundle\SecurityBundle::class => ['all' => TRUE],
    Symfony\Bundle\MonologBundle\MonologBundle::class => ['all' => TRUE],
    Symfony\Bundle\MakerBundle\MakerBundle::class => ['dev' => TRUE],
];
