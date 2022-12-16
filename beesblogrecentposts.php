<?php
/**
 * Copyright (C) 2019 thirty bees
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@thirtybees.com so we can send you a copy immediately.
 *
 * @author    thirty bees <modules@thirtybees.com>
 * @copyright 2019 thirty bees
 * @license   Academic Free License (AFL 3.0)
 */

use BeesBlogModule\BeesBlogPost;

if (!defined('_TB_VERSION_')) {
    exit;
}

/**
 * Class BeesBlogRecentPosts
 */
class BeesBlogRecentPosts extends Module
{
    /**
     * BeesBlogRecentPosts constructor.
     * @throws PrestaShopException
     */
    public function __construct()
    {
        $this->name = 'beesblogrecentposts';
        $this->tab = 'front_office_features';
        $this->version = '1.0.3';
        $this->author = 'thirty bees';

        $this->bootstrap = true;

        parent::__construct();
        $this->displayName = $this->l('Bees Blog Recent Posts');
        $this->description = $this->l('thirty bees blog recent posts widget');
        $this->dependencies  = ['beesblog'];
        $this->need_instance = false;
        $this->tb_versions_compliancy = '>= 1.0.0';
        $this->tb_min_version = '1.0.0';
    }

    /**
     * @return bool
     *
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     * @since 1.0.0
     */
    public function install()
    {
        return (
            parent::install() &&
            $this->registerHook('displayLeftColumn') &&
            $this->registerHook('displayHome') &&
            $this->registerHook('displayFooterProduct')
        );
    }

    /**
     * Display in left column
     *
     * @return string
     *
     * @throws PrestaShopException
     * @throws SmartyException
     * @since 1.0.0
     */
    public function hookDisplayLeftColumn()
    {
        if (!Module::isEnabled('beesblog')) {
            return '';
        }

        $this->context->smarty->assign([
            'beesblogRecentPostsPosts' => BeesBlogPost::getPosts($this->context->language->id, 0, 5),
            'beesblogRecentPostsBlogUrl' => BeesBlog::getBeesBlogLink(),
        ]);

        return $this->display(__FILE__, 'views/templates/hooks/column.tpl');
    }

    /**
     * Display in right column
     *
     * @return string
     *
     * @throws PrestaShopException
     * @throws SmartyException
     * @since 1.0.0
     */
    public function hookDisplayRightColumn()
    {
        return $this->hookDisplayLeftColumn();
    }

    /**
     * Display in home page
     *
     * @return string
     *
     * @throws PrestaShopException
     * @throws SmartyException
     * @since 1.0.3
     */
    public function hookDisplayHome()
    {
        if (!Module::isEnabled('beesblog')) {
            return '';
        }

        $this->context->smarty->assign([
            'beesblogRecentPostsPosts' => BeesBlogPost::getPosts($this->context->language->id, 0, 4),
            'beesblogRecentPostsBlogUrl' => BeesBlog::getBeesBlogLink(),
        ]);

        return $this->display(__FILE__, 'views/templates/hooks/home.tpl');
    }

    /**
     * Display in product page
     *
     * @return string
     *
     * @throws PrestaShopException
     * @throws SmartyException
     * @since 1.0.3
     */
    public function hookDisplayFooterProduct()
    {
        if (!Module::isEnabled('beesblog')) {
            return '';
        }

        $this->context->smarty->assign([
            'beesblogRecentPostsPosts' => BeesBlogPost::getPosts($this->context->language->id, 0, 4),
            'beesblogRecentPostsBlogUrl' => BeesBlog::getBeesBlogLink(),
        ]);

        return $this->display(__FILE__, 'views/templates/hooks/product.tpl');
    }
}
