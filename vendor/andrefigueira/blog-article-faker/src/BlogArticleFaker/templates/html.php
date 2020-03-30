<?php

    if(rand(1, 5) > 3){
        $pageBreak = '<!-- pagebreak -->';
    }else{
        $pageBreak = '<!-- {{ paragraph }} -->';
    }



return [
    "
    {{ sentence }}

    <p>{{ paragraph }}</p>
        <img src=\"{{ image }}\" />
    <p>{{ paragraph }}</p>

    $pageBreak

    {{ paragraphs }}

    ",
];