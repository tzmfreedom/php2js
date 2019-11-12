<?php

use PhpParser\ParserFactory;

require 'vendor/autoload.php';
require 'src/Converter.php';

$code = <<<'EOS'
<?php

class Hoge 
{
    function fuga($i) {
        hoge($i);
        $i = 123;
        $j = 123;
        for ($i = 0; $i < 10; $i++) {
            ;
        }
        foreach ($items as $item) {
            echo $item;
        }
    }
}
EOS;
$parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
try {
    $ast = $parser->parse($code);
} catch (Error $error) {
    echo "Parse error: {$error->getMessage()}\n";
    return;
}

//$dumper = new NodeDumper;
//echo $dumper->dump($ast) . "\n";

$converter = new \Php2Js\Converter();
echo $converter->prettyPrintFile($ast);
