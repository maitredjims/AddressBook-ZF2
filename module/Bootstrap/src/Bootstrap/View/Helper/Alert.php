<?php

namespace Bootstrap\View\Helper;

use Zend\View\Helper\AbstractHelper;

class Alert extends AbstractHelper
{
    public function __invoke($message, $type = 'success') {
        $html = <<<HEREDOC
<div class="alert alert-$type alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  $message
</div>
HEREDOC;
        
        return $html;
    }
}
