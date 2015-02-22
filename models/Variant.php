<?php

class Variant extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     */
    protected $product_name;

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var string
     */
    protected $sku;

    /**
     *
     * @var integer
     */
    protected $quantity;

    /**
     *
     * @var integer
     */
    protected $price;

    /**
     *
     * @var integer
     */
    protected $shopify_id;

    /**
     *
     * @var integer
     */
    protected $product_id;

    /**
     * Method to set the value of field product_name
     *
     * @param string $product_name
     * @return $this
     */
    public function setProductName($product_name)
    {
        $this->product_name = $product_name;

        return $this;
    }

    /**
     * Method to set the value of field id
     *
     * @param integer $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Method to set the value of field sku
     *
     * @param string $sku
     * @return $this
     */
    public function setSku($sku)
    {
        $this->sku = $sku;

        return $this;
    }

    /**
     * Method to set the value of field quantity
     *
     * @param integer $quantity
     * @return $this
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Method to set the value of field price
     *
     * @param integer $price
     * @return $this
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Method to set the value of field shopify_id
     *
     * @param integer $shopify_id
     * @return $this
     */
    public function setShopifyId($shopify_id)
    {
        $this->shopify_id = $shopify_id;

        return $this;
    }

    /**
     * Method to set the value of field product_id
     *
     * @param integer $product_id
     * @return $this
     */
    public function setProductId($product_id)
    {
        $this->product_id = $product_id;

        return $this;
    }

    /**
     * Returns the value of field product_name
     *
     * @return string
     */
    public function getProductName()
    {
        return $this->product_name;
    }

    /**
     * Returns the value of field id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the value of field sku
     *
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * Returns the value of field quantity
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Returns the value of field price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Returns the value of field shopify_id
     *
     * @return integer
     */
    public function getShopifyId()
    {
        return $this->shopify_id;
    }

    /**
     * Returns the value of field product_id
     *
     * @return integer
     */
    public function getProductId()
    {
        return $this->product_id;
    }

    /**
     * @return Variant[]
     */
    public static function find($parameters = array())
    {
        return parent::find($parameters);
    }

    /**
     * @return Variant
     */
    public static function findFirst($parameters = array())
    {
        return parent::findFirst($parameters);
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'product_name' => 'product_name', 
            'id' => 'id', 
            'sku' => 'sku', 
            'quantity' => 'quantity', 
            'price' => 'price', 
            'shopify_id' => 'shopify_id', 
            'product_id' => 'product_id'
        );
    }

}
