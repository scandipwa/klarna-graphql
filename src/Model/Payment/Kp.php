<?php
/**
 * ScandiPWA_KlarnaGraphQl
 *
 * @category    ScandiPWA
 * @package     ScandiPWA_KlarnaGraphQl
 * @author      Artjoms Travkovs <info@scandiweb.com>
 * @copyright   Copyright (c) 2019 Scandiweb, Ltd (https://scandiweb.com)
 */
namespace ScandiPWA\KlarnaGraphQl\Model\Payment;

use Klarna\Kp\Model\Payment\Kp as KpSource;
use Klarna\Kp\Model\SessionInitiatorFactory;
use Magento\Payment\Model\Method\Adapter;
use Magento\Framework\Locale\Resolver;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Store\Model\StoreManagerInterface;
use \Magento\Framework\Exception\NoSuchEntityException;

class Kp extends KpSource
{
    private const DEFAULT_TITLE = 'Klarna Payments';
    private const KLARNA_TITLE_PATH = 'payment/klarna_kp/title';

    /**
     * @var Adapter
     */
    private $adapter;

    /**
     * @var ScopeConfigInterface
     */
    private $config;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @param Adapter $adapter
     * @param Resolver $resolver
     * @param ScopeConfigInterface $config
     * @param SessionInitiatorFactory $sessionInitiatorFactory
     */
    public function __construct(
        Adapter $adapter,
        Resolver $resolver,
        ScopeConfigInterface $config,
        SessionInitiatorFactory $sessionInitiatorFactory,
        StoreManagerInterface $storeManager
    ) {
        parent::__construct($adapter, $resolver, $config, $sessionInitiatorFactory);
        $this->adapter = $adapter;
        $this->config = $config;
        $this->storeManager = $storeManager;
    }

    /**
     * {@inheritDoc}
     */
    public function isAvailable(?CartInterface $quote = null)
    {
        return !!$this->adapter->isAvailable($quote);
    }

    /**
     * Fixes issue with klarna un-linking after
     * failed purchase atempt, by catcginh title from
     * config directly
     */
    public function getTitle()
    {
        try {
            return parent::getTitle();
        } catch (NoSuchEntityException $exception) {
            return $this->config->getValue(
                self::KLARNA_TITLE_PATH,
                'store',
                $this->storeManager->getStore()->getId()
            ) ?? __(self::DEFAULT_TITLE);
        }
    }
}
