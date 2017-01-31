<?php

namespace Gearbox\Document;

use PHPUnit\Framework\TestCase;

class DocumentTest extends TestCase
{
    public function hasProvider()
    {
        $defaultPreconditions = [];

        $defaultExpectations = [
            'found' => true
        ];

        $testCases = [
            'PC: Try to find without a field in empty array' => [
                'preconditions' => [
                    'sourceArray' => [],
                    'field' => null
                ],
                'expectations' => [
                    'found' => false
                ]
            ],
            'PC: Try to find without a field in array' => [
                'preconditions' => [
                    'sourceArray' => [
                        'test' => 'data'
                    ],
                    'field' => null
                ],
                'expectations' => [
                    'found' => false
                ]
            ],
            'PC: Try to find field in empty array' => [
                'preconditions' => [
                    'sourceArray' => [],
                    'field' => ['hidden', 'gold']
                ],
                'expectations' => [
                    'found' => false
                ]
            ],
            'PC: Try to find missing field in array' => [
                'preconditions' => [
                    'sourceArray' => [
                        'foo' => 'bar'
                    ],
                    'field' => ['hidden', 'gold']
                ],
                'expectations' => [
                    'found' => false
                ]
            ],
            'PC: Find existing field in array' => [
                'preconditions' => [
                    'sourceArray' => [
                        'foo' => 'bar',
                        'hidden' => [
                            'gold' => 'here'
                        ]
                    ],
                    'field' => ['hidden', 'gold']
                ],
                'expectations' => [
                    'found' => true
                ]
            ],
            'PC: Delete deep field from array' => [
                'preconditions' => [
                    'sourceArray' => [
                        'deeply' => [
                            'hidden' => [
                                'stuff' => 'forgotten',
                                'gold' => 'stolen'
                            ]
                        ]
                    ],
                    'field' => ['deeply', 'hidden', 'gold']
                ],
                'expectations' => [
                    'found' => true
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
     * @dataProvider hasProvider
     */
    public function testHas($preconditions, $expectations)
    {
        $document = new Document($preconditions['sourceArray']);
        $hasField = $document->has($preconditions['field']);

        $this->assertSame($expectations['found'], $hasField, 'The result of has is not correct.');
    }



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