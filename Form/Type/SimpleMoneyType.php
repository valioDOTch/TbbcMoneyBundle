<?php

namespace Tbbc\MoneyBundle\Form\Type;

use Money\Currency;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tbbc\MoneyBundle\Form\DataMapper\SimpleMoneyDataMapper;
use Tbbc\MoneyBundle\Pair\PairManagerInterface;

/**
 * Form type for the Money object.
 */
class SimpleMoneyType extends AbstractType
{
    /** @var  PairManagerInterface */
    protected $pairManager;

    /** @var  int */
    protected $decimals;

    /**
     * SimpleMoneyType constructor.
     *
     * @param PairManagerInterface $pairManager
     * @param int                  $decimals
     */
    public function __construct(PairManagerInterface $pairManager, $decimals)
    {
        $this->pairManager = $pairManager;
        $this->decimals = (int) $decimals;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tbbc_amount', 'Symfony\Component\Form\Extension\Core\Type\TextType')
            ->setDataMapper(new SimpleMoneyDataMapper(
                $this->decimals,
                new Currency($this->pairManager->getReferenceCurrencyCode())
            ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults(array(
                'data_class' => 'Money\Money',
                'empty_data' => null,
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tbbc_simple_money';
    }
}
