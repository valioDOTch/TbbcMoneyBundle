<?php
namespace Tbbc\MoneyBundle\Form\DataMapper;

use Money\Currency;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;

/**
 * Class CurrencyDataMapper
 * @package Tbbc\MoneyBundle\Form\DataMapper
 */
class CurrencyDataMapper implements DataMapperInterface
{
    /**
     * {@inheritdoc}
     */
    public function mapDataToForms($data, $forms)
    {
        if ($data === null) {
            return null;
        }

        if (!$data instanceof Currency) {
            throw new UnexpectedTypeException($data, 'Currency');
        }

        $forms = iterator_to_array($forms);
        $forms['tbbc_name']->setData($data ? $data->getName() : null);
    }

    /**
     * {@inheritdoc}
     */
    public function mapFormsToData($forms, &$data)
    {
        $forms = iterator_to_array($forms);
        $currency = $forms['tbbc_name']->getData();

        $data = $currency ? new Currency($currency) : null;
    }
}
