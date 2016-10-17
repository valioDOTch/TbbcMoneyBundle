<?php
namespace Tbbc\MoneyBundle\Form\DataMapper;

use Symfony\Component\Form\DataMapperInterface;
use Tbbc\MoneyBundle\Form\DataTransformer\MoneyToArrayTransformer;

/**
 * Class MoneyDataMapper
 * @package Tbbc\MoneyBundle\Form\DataMapper
 */
class MoneyDataMapper implements DataMapperInterface
{
    /**
     * @var MoneyToArrayTransformer
     */
    protected $transformer;

    /**
     * MoneyToArrayTransformer constructor.
     *
     * @param int $decimals
     */
    public function __construct($decimals = 2)
    {
        $this->transformer = new MoneyToArrayTransformer($decimals);
    }

    /**
     * {@inheritdoc}
     */
    public function mapDataToForms($data, $forms)
    {
        $data = $this->transformer->transform($data);

        $forms = iterator_to_array($forms);
        $forms['tbbc_amount']->setData($data ? $data['tbbc_amount'] : null);
        $forms['tbbc_currency']->setData($data ? $data['tbbc_currency'] : null);
    }

    /**
     * {@inheritdoc}
     */
    public function mapFormsToData($forms, &$data)
    {
        $forms = iterator_to_array($forms);

        $input = array(
            'tbbc_amount'   => $forms['tbbc_amount']->getData(),
            'tbbc_currency' => $forms['tbbc_currency']->getData(),
        );
        $data = $this->transformer->reverseTransform($input);
    }
}
