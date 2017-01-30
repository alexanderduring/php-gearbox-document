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
            'PC: Try to delete without keys from empty array' => [
                'preconditions' => [
                    'sourceArray' => [],
                    'deleteField' => null
                ],
                'expectations' => [
                    'targetArray' => []
                ]
            ],
            'PC: Try to delete without keys from array' => [
                'preconditions' => [
                    'sourceArray' => [
                        'test' => 'data'
                    ],
                    'deleteField' => null
                ],
                'expectations' => [
                    'targetArray' => [
                        'test' => 'data'
                    ]
                ]
            ],
            'PC: Try to delete field from empty array' => [
                'preconditions' => [
                    'sourceArray' => []
                ],
                'expectations' => [
                    'targetArray' => []
                ]
            ],
            'PC: Try to delete missing field from array' => [
                'preconditions' => [
                    'sourceArray' => [
                        'foo' => 'bar'
                    ]
                ],
                'expectations' => [
                    'targetArray' => [
                        'foo' => 'bar'
                    ]
                ]
            ],
            'PC: Delete field from array' => [
                'preconditions' => [
                    'sourceArray' => [
                        'foo' => 'bar',
                        'not-needed' => 'baz'
                    ]
                ],
                'expectations' => [
                    'targetArray' => [
                        'foo' => 'bar'
                    ]
                ]
            ],
            'PC: Delete deep field from array' => [
                'preconditions' => [
                    'sourceArray' => [
                        'foo' => [
                            'bar' => [
                                'baz' => 'test',
                                'not-needed' => 'empty'
                            ]
                        ]
                    ],
                    'deleteField' => ['foo', 'bar', 'not-needed']
                ],
                'expectations' => [
                    'targetArray' => [
                        'foo' => [
                            'bar' => [
                                'baz' => 'test'
                            ]
                        ]
                    ]
                ]
            ],
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