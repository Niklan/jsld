<?php

namespace Drupal\jsld\Generator;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Class JsldEntityPluginGenerator
 *
 * @package Drupal\jsld\Generators
 */
class JsldEntityPluginGenerator extends BaseGenerator {

  protected $name = 'jsld-entity';

  protected $description = 'Generates Json-LD plugin for entity.';

  protected $templatePath = __DIR__;

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions();
    // Ask for Plugin ID.
    $questions['plugin_id'] = new Question('Plugin ID');
    $questions['plugin_id']->setValidator([Utils::class, 'validateRequired']);
    // Ask for entity type.
    $questions['entity_type'] = new Question('Entity type');
    $questions['entity_type']->setValidator([Utils::class, 'validateRequired']);
    $vars = &$this->collectVars($input, $output, $questions);
    $vars['name'] = Utils::camelize($vars['plugin_id']);
    $this->addFile()
      ->path('src/Plugin/jsld/entity/{name}.php')
      ->template('jsld-entity-plugin.html.twig');
  }

}