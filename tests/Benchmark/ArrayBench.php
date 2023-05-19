<?php
declare(strict_types=1);

namespace Phauthentic\Test\Benchmark;

use Phauthentic\Validator\Utility\ArrayHelper;

class ArrayBench
{
    protected function getArray()
    {
        return [
            'foo' => [
                [
                    'bar' => [
                        'id' => 1
                    ]
                ],
                [
                    'bar' => [
                        'id' => 2
                    ]
                ],
                [
                    'bar' => [
                        'id' => 3
                    ]
                ]
            ]
        ];
    }

    /**
     * @Iterations(5)
     * @Revs(1000)
     */
    public function benchArrayHas()
    {
        $result = ArrayHelper::arrayHas($this->getArray(),'foo.1.bar.id');
        assert($result);
    }

    /**
     * @Iterations(5)
     * @Revs(1000)
     */
    public function benchNativeArrayHasViaIsset()
    {
        $result = isset($this->getArray()['foo'][1]['bar']['id']);
        assert($result);
    }

    /**
     * @Iterations(5)
     * @Revs(1000)
     */
    public function benchArrayGet()
    {
        $result = ArrayHelper::arrayGet($this->getArray(),'foo.1.bar.id');
        assert($result);
    }

    /**
     * @Iterations(5)
     * @Revs(1000)
     */
    public function benchNativeArrayGet()
    {
        if (isset(['foo'][1]['bar']['id'])) {
            $result = $this->getArray()['foo'][1]['bar']['id'];
            assert($result);
        }
    }
}
