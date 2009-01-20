{if and( is_set( $validation.processed ),
         and( $validation.processed,
              $collection_attributes ) )}
    <div class="message-warning">
        {if $validation.attributes}
            <h2>Votre message n'a pu être envoyé</h2>
            <p>Des données requises sont manquantes ou mal formées&nbsp;:</p>
            <ul>
                {foreach $validation.attributes as $attr}
                    <li><strong>{$attr.name|wash}</strong>&nbsp;: {$attr.description|wash()}</li>
                {/foreach}
            </ul>
        {/if}
    </div>
{elseif is_set( $view_parameters.send )}
    <div class="message-success">
        <h2>Votre message a bien été envoyé</h2>
    </div>
{/if}
