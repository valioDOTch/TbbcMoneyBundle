<?php
namespace Tbbc\MoneyBundle\Form\DataMapper;

use Symfony\Component\Form\DataMapperInterface;
use Tbbc\MoneyBundle\Form\DataTransformer\CurrencyToArrayTransformer;

/**
 * Class CurrencyDataMapper
 * @package Tbbc\MoneyBundle\Form\DataMapper
 */
final class CurrencyDataMapper implements DataMapperInterface
{
    /**
     * @var CurrencyToArrayTransformer
     */
    private $transformer;

    /**
     * CurrencyDataMapper constructor.
     */
    public function __construct()
    {
        $this->transformer = new CurrencyToArrayTransformer();
    }

    /**
     * {@inheritdoc}
     */
    public function mapDataToForms($data, $forms)
    {
        $data = $this->transformer->transform($data);

        $forms = iterator_to_array($forms);
        $forms['tbbc_name']->setData($data ? $data['tbbc_name'] : null);
    }

    /**
     * {@inheritdoc}
     */
    public function mapFormsToData($forms, &$data)
    {
        $forms = iterator_to_array($forms);

        $data = $this->transformer->reverseTransform([
            'tbbc_name' => $forms['tbbc_name']->getData(),
        ]);
    }
}
