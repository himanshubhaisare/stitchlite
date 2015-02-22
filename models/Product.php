<?php

class Product extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var integer
     */
    protected $shopify_id;

    /**
     *
     * @var string
     */
    protected $product_name;

    /**
     *
     * @var string
     */
    protected $type;

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
     * Method to set the value of field type
     *
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
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
     * Returns the value of field shopify_id
     *
     * @return integer
     */
    public function getShopifyId()
    {
        return $this->shopify_id;
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
     * Returns the value of field type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return Product[]
     */
    public static function find($parameters = array())
    {
        return parent::find($parameters);
    }

    /**
     * @return Product
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
            'id' => 'id', 
            'shopify_id' => 'shopify_id', 
            'product_name' => 'product_name', 
            'type' => 'type'
        );
    }

}
