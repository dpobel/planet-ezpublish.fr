<?php


namespace Planet\PlanetBundle\Legacy\View;

use eZ\Publish\Core\MVC\Legacy\View\TwigContentViewLayoutDecorator as CoreDecorator;


class TwigContentViewLayoutDecorator extends CoreDecorator
{
   public function getTemplateIdentifier()
    {
        $options = $this->options;
        $contentView = $this->contentView;
        $twig = $this->twig;

        return function ( array $params ) use ( $options, $contentView, $twig )
        {
            $contentViewClosure = $contentView->getTemplateIdentifier();
            $layout = $options['layout'];
            if ( isset( $params['noLayout'] ) && $params['noLayout'] )
            {
                $layout = $options['viewbaseLayout'];
            }
            $twigContentTemplate = <<<EOT
{% extends "{$layout}" %}

{% block top_menu %}
    {% set selected = location.id %}
    {{ parent() }}
{% endblock %}

{% block {$options['contentBlockName']} %}
{{ viewResult|raw }}
{% endblock %}
EOT;
            return $twig->render(
                $twigContentTemplate,
                array(
                     'location' => isset( $params['location'] ) ? $params['location'] : null,
                     'content' => isset( $params['content'] ) ? $params['content'] : null,
                     'viewResult' => $contentViewClosure( $params )
                )
            );
        };
    }


}
