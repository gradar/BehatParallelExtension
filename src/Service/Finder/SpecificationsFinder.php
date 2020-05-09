<?php

namespace DMarynicz\BehatParallelExtension\Service\Finder;

use Behat\Testwork\Specification\GroupedSpecificationIterator;
use Behat\Testwork\Specification\SpecificationFinder as TestworkSpecificationFinder;
use Behat\Testwork\Specification\SpecificationIterator;
use Behat\Testwork\Suite\Suite;
use Behat\Testwork\Suite\SuiteRepository;

class SpecificationsFinder
{
    /** @var SuiteRepository */
    private $suiteRepository;

    /** @var TestworkSpecificationFinder */
    private $specificationFinder;

    public function __construct(
        SuiteRepository $suiteRepository,
        TestworkSpecificationFinder $specificationFinder
    ) {
        $this->suiteRepository     = $suiteRepository;
        $this->specificationFinder = $specificationFinder;
    }

    /**
     * @param string|null $path
     *
     * @return GroupedSpecificationIterator[]
     */
    public function findGroupedSpecifications($path)
    {
        $specs = $this->findSpecifications($path);

        return GroupedSpecificationIterator::group($specs);
    }

    /**
     * Finds exercise specifications.
     *
     * @param string|null $path
     *
     * @return SpecificationIterator[]
     */
    public function findSpecifications($path)
    {
        return $this->findSuitesSpecifications($this->getAvailableSuites(), $path);
    }

    /**
     * Finds specification iterators for all provided suites using locator.
     *
     * @param Suite[]     $suites
     * @param string|null $locator
     *
     * @return SpecificationIterator[]
     */
    protected function findSuitesSpecifications($suites, $locator)
    {
        return $this->specificationFinder->findSuitesSpecifications($suites, $locator);
    }

    /**
     * Returns all currently available suites.
     *
     * @return Suite[]
     */
    protected function getAvailableSuites()
    {
        return $this->suiteRepository->getSuites();
    }
}
