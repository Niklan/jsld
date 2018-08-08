<?php

namespace Drupal\jsld\Generator;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * Class JsldPathPluginGenerator.
 *
 * @package Drupal\jsld\Generators
 */
class JsldPathPluginGenerator extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected $name = 'plugin-jsld-path';

  /**
   * {@inheritdoc}
   */
  protected $alias = 'jsld-path';

  /**
   * {@inheritdoc}
   */
  protected $description = 'Generates JSON-LD base plugin for paths.';

  /**
   * {@inheritdoc}
   */
  protected $templatePath = __DIR__;

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions();
    // Ask for Plugin ID.
    $questions['plugin_id'] = new Question('Plugin ID');
    $questions['plugin_id']->setValidator([Utils::class, 'validateRequired']);
    // Ask for match type.
    $match_type_choices = [
      0 => 'listed',
      1 => 'unlisted',
    ];
    $questions['match_type'] = new ChoiceQuestion('Path match type', $match_type_choices, 0);
    $questions['match_type']->setValidator([Utils::class, 'validateRequired']);
    $vars = &$this->collectVars($input, $output, $questions);
    $vars['name'] = Utils::camelize($vars['plugin_id']);
    $this->addFile()
      ->path('src/Plugin/jsld/path/{name}.php')
      ->template('jsld-path-plugin.html.twig');
  }

}
