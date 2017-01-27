<?php

namespace Gearbox\Document;

use PHPUnit\Framework\TestCase;

class DocumentTest extends TestCase
{
    public function deleteProvider()
    {
        $defaultPreconditions = [
            'deleteField' => ['not-needed']
        ];

        $defaultExpectations = [];

        $testCases = [
            'Delete field from empty array' => [
                'preconditions' => [
                    'sourceArray' => []
                ],
                'expectations' => [
                    'targetArray' => []
                ]
            ]
        ];

        // Merge test data with default data
        foreach ($testCases as &$testCase) {
            $testCase['preconditions'] = array_merge($defaultPreconditions, $testCase['preconditions']);
            $testCase['expectations'] = array_merge($defaultExpectations, $testCase['expectations']);
        }

        return $testCases;
    }



    /**
     * @dataProvider deleteProvider
     */
    public function testDelete($preconditions, $expectations)
    {
        $document = new Document($preconditions['sourceArray']);
        $document->delete($preconditions['deleteField']);

        $this->assertSame($expectations['targetArray'], $document->toArray(), 'The returned array is not correct.');
    }
}