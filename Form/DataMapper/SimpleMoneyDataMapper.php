<?php
namespace Tbbc\MoneyBundle\Form\DataMapper;

use Money\Currency;
use Symfony\Component\Form\DataMapperInterface;
use Tbbc\MoneyBundle\Form\DataTransformer\MoneyToArrayTransformer;

/**
 * Class SimpleMoneyDataMapper
 * @package Tbbc\MoneyBundle\Form\DataMapper
 */
final class SimpleMoneyDataMapper implements DataMapperInterface
{
    /**
     * @var MoneyToArrayTransformer
     */
    protected $transformer;

    /**
     * @var Currency
     */
    protected $fixedCurrency;

    /**
     * MoneyToArrayTransformer constructor.
     *
     * @param int      $decimals
     * @param Currency $fixedCurrency
     */
    public function __construct($decimals = 2, Currency $fixedCurrency)
    {
        $this->transformer = new MoneyToArrayTransformer($decimals);
        $this->fixedCurrency = $fixedCurrency;
    }

    /**
     * {@inheritdoc}
     */
    public function mapDataToForms($data, $forms)
    {
        $data = $this->transformer->transform($data);

        $forms = iterator_to_array($forms);
        $forms['tbbc_amount']->setData($data ? $data['tbbc_amount'] : null);
    }

    /**
     * {@inheritdoc}
     */
    public function mapFormsToData($forms, &$data)
    {
        $forms = iterator_to_array($forms);

        $input = array(
            'tbbc_amount'   => $forms['tbbc_amount']->getData(),
            'tbbc_currency' => $this->fixedCurrency,
        );
        $data = $this->transformer->reverseTransform($input);
    }
}
