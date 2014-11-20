<?php
/**
 * Amazon Library
 * 
 * You have to edit the definitions at the beginning of this file.
 * # AMAZON_SECRET_KEY: Your secret Api Key. Required for hashing and auth.
 * # AMAZON_API_KEY: Your public Api Key
 * # AMAZON_ASSOC_TAG: Your associate ID
 *
 * @version 0.1
 * @author m3nt0r <mail@m3nt0r.de> 
 * @copyright Copyright (c) 2007, Kjell Bublitz
 * @since 2007-01-14
 * @link http://www.m3nt0r.de/amazon_webservice_klasse/ The Authors Homepage
 * @link http://www.amazon.com/gp/browse.html?node=3435361 Amazon Web Services Homepage
 */

define('AMAZON_SECRET_KEY', '<your_secret_api_key>');
define('AMAZON_API_KEY', '<your_public_api_key>');
define('AMAZON_ASSOC_TAG', "<your_associate_id>");

/**
 * Amazon Base Class
 * 
 * @author m3nt0r <mail@m3nt0r.de> 
 * @copyright Copyright (c) 2007, Kjell Bublitz
 * @version 0.1
 * @access public 
 */
class Amazon
{ 
    // Your secret Api Key. Required for hashing and auth.
    var $secret_access_key = ""; 
    // Your public Api Key
    var $access_key = ""; 
    // Your associate ID
    var $associate_tag = ""; 
    // Serveradress of the webservice
    var $server = ""; 
    // Service Name
    var $service = ""; 
    // The type of Operation
    var $operation = ""; 
    // States which representation should be used.
    var $responseGroup = ""; 
    // Some Services need a version string, stored here.
    var $version = ""; 
    // Last query URL used
    var $queryUrl = ""; 
    // If true, the signature auth will be used.
    var $use_signatureAuth = false; 
    // If true, the associate Id will be used.
    var $use_associateTag = true;

    /**
     * Constructor
     * 
     * @param string $skey Your secret API-Key.
     * @param string $akey Your public API-Key.
     */
    function Amazon()
    {
        $this->secret_access_key = AMAZON_SECRET_KEY;
        $this->access_key = AMAZON_API_KEY;
        $this->associate_tag = AMAZON_ASSOC_TAG;
    } 

    /**
     * This function returns a time stamp in the format required by Amazon.
     * 
     * Note: Amazon will not respond to a request unless its timestamp is accurate 
     * to within about 20 minutes, so make sure the time is set correctly on your server.
     *
     * @author ooba <ooba _AT_ associateshaven.com>
     * @author m3nt0r <mail@m3nt0r.de>
     * 
     * @return string Current raw timestamp (date: c).
     */
    function make_timestamp()
    {
        $timestamp = date("c", time());
        return $timestamp;
    } 

    /**
     * This function returns a hashed signature as required by 
     * Amazon to authenticate the request.
     * 
     * Note: The mhash library must be enabled on your server 
     * in order for this to work.
     * 
     * @author ooba <ooba _AT_ associateshaven.com>
     * @author m3nt0r <mail@m3nt0r.de>
     * 
     * @return string urlencoded HMAC security token.
     */
    function make_signature()
    {
        $timestamp = $this->make_timestamp();
        $sig = $this->service . $this->operation . $timestamp; // right order
        $hmac = mhash(MHASH_SHA1, $sig, $this->secret_access_key);
        $encoded_hmac = base64_encode($hmac);

        return urlencode($encoded_hmac);
    } 

    /**
     * Creates a basic request URL with all default arquments.
     * 
     * @return string Basic Request URL
     */
    function make_url()
    {
        $query_url = "http://" . $this->server . "/onca/xml";
        $query_url .= "?Service=" . $this->service;

        if (strlen($this->version) > 1)
        {
            $query_url .= "&Version=" . $this->version;
        } 

        $query_url .= "&AWSAccessKeyId=" . $this->access_key;

        if ($this->use_signatureAuth)
        {
            $query_url .= "&Signature=" . $this->make_signature();
            $query_url .= "&Timestamp=" . urlencode($this->make_timestamp());
        } 

        if ($this->use_associateTag)
        {
            $query_url .= "&AssociateTag=" . $this->associate_tag;
        } 

        $query_url .= "&Operation=" . $this->operation;

        if (strlen($this->responseGroup) > 1)
        {
            $query_url .= "&ResponseGroup=" . $this->responseGroup;
        } 

        return $query_url;
    } 
} 

/**
 * AmazonECS Class
 * 
 * @author m3nt0r <mail@m3nt0r.de> 
 * @copyright Copyright (c) 2007, Kjell Bublitz
 * @version 0.1
 * @access public 
 */
class AmazonECS extends Amazon
{
    /**
     * Constructor
     * 
     * Note: AmazonECS does not use the signature auth system.
     * 
     * Note: AmazonECS is using Associate Tag by default.
     */
    function AmazonECS()
    {
        $this->Amazon();
        $this->server = "ecs.amazonaws.com";
        $this->service = "AWSECommerceService";
        $this->version = "2006-11-14";
        $this->use_signatureAuth = false;
        $this->use_associateTag = true;
    } 
} 

/**
 * AmazonECS Item Class
 * The Amazon E-Commerce Service (ECS) item operations allow you to search for and retrieve information about products listed on Amazon Web sites.
 * 
 * @author m3nt0r <mail@m3nt0r.de> 
 * @copyright Copyright (c) 2007, Kjell Bublitz
 * @version 0.1
 * @access public 
 */
class AmazonECS_Item extends AmazonECS
{
    /**
     * Constructor
     */
    function AmazonECS_Item()
    {
        $this->AmazonECS();
    } 

    /**
     * The ItemLookup operation enables you to retrieve catalog information for 
     * up to ten products or restaurants (US only). It provides access to customer 
     * reviews, variations, product similarities, pricing, availability, images, 
     * product accessories, and other information.
     * 
     * @link http://docs.amazonwebservices.com/AWSEcommerceService/2006-11-14/ApiReference/ItemLookupOperation.html Amazon Docs for this Operation
     * @param string $itemId The ASIN you want to look up. If not specified a differnt type. 
     * @param string $idType Valid types are: ASIN, SKU (US only), UPC (US only), EAN (DE/JP/CA only)
     * @param integer $page If there are more then 10 results you can page through them with this argument. (1-100)
     * @param string $searchIndex Required for UPC, SKU or EAN searches. Valid Indicies are 'DVD', 'Books', 'Music', 'Software', etc..
     * @param string $merchant Required for SKU search; otherwise optional. Valid are: All, Amazon, Featured (US only), a merchant ID (US only)
     * @param string $responseGroup Valid Groups are Request, ItemIds, Small, Medium, Large, Offers, and more..
     * @return string XML Response Document
     */
    function ItemLookup($itemId, $idType = "ASIN", $searchIndex = "", $page = 0, $merchant = "Amazon", $responseGroup = "Small")
    {
        $this->operation = "ItemLookup";
        $this->responseGroup = $responseGroup;

        $query_url = $this->make_url();
        $query_url .= "&ItemId=". $itemId;
        $query_url .= "&IdType=". $idType;
        $query_url .= "&MerchantId=". $merchant;

        if ($searchIndex)
        {
            $query_url .= "&SearchIndex=". $searchIndex;
        }
        if ($page)
        {
            $query_url .= "&OfferPage=".$page;    
        }
        
        $this->queryUrl = $query_url;

        return file_get_contents($this->queryUrl);
    } 

    /**
     * The ItemSearch operation enables you to search for products for a given search 
     * index or combination (blend) of search indices. This operation automatically 
     * corrects misspelled search words and displays the corrected word used in 
     * the search. In a blended search, the operation corrects the mispelled word 
     * in each SearchIndex. For example, if “propine” is the search word, “provine” 
     * might be used.
     * 
     * @link http://docs.amazonwebservices.com/AWSEcommerceService/2006-11-14/ApiReference/ItemSearchOperation.html Amazon Docs for this Operation
     * @param string $keywords Anything you want to search for. Example: 'Matrix Movie'
     * @param string $searchIndex Valid Indicies are 'DVD', 'Books', 'Music', 'Software', etc..
     * @param string $responseGroup Valid Groups are Request, ItemIds, Small, Medium, Large, Offers, and more..
     * @return string XML Response Document
     */
    function ItemSearch($keywords, $searchIndex, $responseGroup = "Request,Small")
    {
        $this->operation = "ItemSearch";
        $this->responseGroup = $responseGroup;

        $query_url = $this->make_url();
        $query_url .= "&SearchIndex=" . $searchIndex;
        $query_url .= "&Keywords=" . urlencode($keywords);

        $this->queryUrl = $query_url;

        return file_get_contents($this->queryUrl);
    } 

    /**
     * The SimilarityLookup operation allows you to retrieve products that are 
     * similar to one or several specific Amazon products. SimilarityLookup may 
     * also be used to retrieve an intersection of similar products for up 
     * to ten specific Amazon products.
     * 
     * Note on $type:
     * Set the value of $type to 'Intersection' to include only products that are 
     * similar to all of the items in the request. Set the value of $type to 'Random' 
     * to include an assortment of similar products corresponding to any of the items 
     * in the request.
     * 
     * @link http://docs.amazonwebservices.com/AWSEcommerceService/2006-11-14/ApiReference/SimilarityLookupOperation.html Amazon Docs for this Operation
     * @param mixed $itemId A single ASIN or an array of ASINs (up to 10)
     * @param string $type Valid types are 'Intersection' and 'Random'. See note.
     * @param string $responseGroup Valid are: Request, ItemIds, Small, Medium, Large, Offers, and more..
     * @param string $merchant Valid are: All, Amazon, Featured, a merchant ID
     * @param string $condition Valid are: All, New, Used, Refurbished, Collectible
     * @param string $delivery Valid are: Ship, ISPU
     * @return string XML Response Document
     */
    function ItemsSimilarTo($itemId, $type = "Random", $responseGroup = "Request,Small", $merchant = "Amazon", $condition = "New", $delivery = "Ship")
    {
        $this->operation = "SimilarityLookup";
        $this->responseGroup = $responseGroup;

        $query_url = $this->make_url();
        $query_url .= "&SimilarityType=" . $type;
        $query_url .= "&MerchantId=" . $merchant;
        $query_url .= "&Condition=" . $condition;
        $query_url .= "&DeliveryMethod=" . $delivery;

        if (is_array($itemId))
        {
            $itemString = "";
            foreach($itemId as $item)
            {
                $itemString .= $item . ",";
            } 
            $query_url .= "&ItemId=" . substr($itemString, 0, strlen($itemString)-1);
        } 
        else
        {
            $query_url .= "&ItemId=" . $itemId;
        } 

        $this->queryUrl = $query_url;

        return file_get_contents($this->queryUrl);
    } 
} 

/**
 * AmazonECS Cart Class
 * The Amazon E-Commerce Service (ECS) remote shopping cart operations allow you to create, modify, view, and clear Amazon shopping carts.
 * 
 * @author m3nt0r <mail@m3nt0r.de> 
 * @copyright Copyright (c) 2007, Kjell Bublitz
 * @version 0.1
 * @access public 
 */
class AmazonECS_Cart extends AmazonECS
{ 
    // The Cart Unique ID (available after Create)
    var $cartId = ""; 
    // The Cart HMAC security token (available after Create)
    var $cartHMAC = ""; 
    // The Purchase URL for check-out. This URL is what the customer must use for the Associate to get credit for the sale. (available after Create)
    var $purchaseURL = "";

    /**
     * Constructor
     */
    function AmazonECS_Cart()
    {
        $this->AmazonECS();
        $this->server = "webservices.amazon.com";
    } 

    /**
     * A CartCreate request must specify at least one product to add to the new 
     * cart. CartCreate cannot create empty shopping carts. The cart lifespan is 
     * currently 90 days from the last date it was accessed.
     * 
     * You must manage the HMAC and CartID outside for each user and assign it
     * back on all method calls. Store it in a database, cookie or session.
     * 
     * If you want to add multiple items at once, then follow this scheme:
     * 
     * # $items[0]['asin'] = 'B000CS3RIW';
     * # $items[0]['quantity'] = 3;
     * # $items[1]['asin'] = 'B000BHZ1DS';
     * #    $items[1]['quantity'] = 1;
     * ...
     * 
     * @link http://docs.amazonwebservices.com/AWSEcommerceService/2006-11-14/ApiReference/CartCreateOperation.html Amazon Docs for this Operation
     * @param array $items An array of ASINs and their quantity
     * @return string XML Response Document
     */
    function CartCreate($items)
    {
        $this->operation = "CartCreate";
        $this->responseGroup = "Cart";

        $itemNum = 0;
        $itemsString = "";

        foreach($items as $item)
        {
            $itemNum++;
            $itemsString .= "&Item." . $itemNum . ".ASIN=" . $item['asin'] . "&Item." . $itemNum . ".Quantity=" . $item['quantity'];
        } 

        $query_url = $this->make_url();
        $query_url .= $itemsString;

        $this->queryUrl = $query_url;

        $xmldoc = file_get_contents($this->queryUrl); 
        // Get the important tracking infos
        preg_match('|<CartId>(.*)</CartId>|i', $xmldoc, $found);
        $this->cartId = $found[0];

        preg_match('|<HMAC>(.*)</HMAC>|i', $xmldoc, $found);
        $this->cartHMAC = $found[0];

        preg_match('|<PurchaseURL>(.*)</PurchaseURL>|i', $xmldoc, $found);
        $this->purchaseURL = $found[0];

        return $xmldoc;
    } 

    /**
     * The CartAdd operation allows you to add items to an existing remote shopping cart.
     * 
     * Note: CartAdd can only be used to place a new product in a shopping cart. 
     * It cannot be used to increase the quantity of an item already in the cart. 
     * If you would like to increase the quantity of an item that is already in 
     * the cart, you will need to use the CartModify operation.
     * 
     * @see AmazonECS_Cart::Create()
     * @link http://docs.amazonwebservices.com/AWSEcommerceService/2006-11-14/ApiReference/CartAddOperation.html Amazon Docs for this Operation
     * @param array $items An array of ASINs and their quantity
     * @param string $responseGroup Valid Groups: Cart, CartSimilarities, CartTopSellers, CartNewReleases
     * @return string XML Response Document
     */
    function CartAdd($items, $responseGroup = "Cart")
    {
        $this->operation = "CartAdd";
        $this->responseGroup = $responseGroup;

        $itemNum = 0;
        $itemsString = "";

        foreach($items as $item)
        {
            $itemNum++;
            $itemsString .= "&Item." . $itemNum . ".ASIN=" . $item['asin'] . "&Item." . $itemNum . ".Quantity=" . $item['quantity'];
        } 

        $query_url = $this->make_url();
        $query_url .= "&CartId=" . $this->cartId;
        $query_url .= "&HMAC=" . $this->cartHMAC;
        $query_url .= $itemsString;

        $this->queryUrl = $query_url;

        return file_get_contents($this->queryUrl);
    } 

    /**
     * The CartGet operation allows you to retrieve the contents of a remote shopping cart.
     * 
     * Note: The cart lifespan is currently 90 days from its last access date.
     * 
     * @link http://docs.amazonwebservices.com/AWSEcommerceService/2006-11-14/ApiReference/CartGetOperation.html Amazon Docs for this Operation
     * @param string $responseGroup Valid Groups: Cart, CartSimilarities, CartTopSellers, CartNewReleases
     * @return string XML Response Document
     */
    function CartGet($responseGroup = "Cart")
    {
        $this->operation = "CartGet";
        $this->responseGroup = $responseGroup;

        $query_url = $this->make_url();
        $query_url .= "&CartId=" . $this->cartId;
        $query_url .= "&HMAC=" . $this->cartHMAC;

        $this->queryUrl = $query_url;

        return file_get_contents($this->queryUrl);
    } 

    /**
     * The CartClear operation allows you to remove all the contents of a remote 
     * shopping cart.
     * 
     * Note: Using CartClear on a shopping cart does not invalidate its CartId 
     * or HMAC. It simply removes all of its contents.
     * 
     * @link http://docs.amazonwebservices.com/AWSEcommerceService/2006-11-14/ApiReference/CartCreateOperation.html Amazon Docs for this Operation
     * @param string $responseGroup Valid Groups: Cart, CartSimilarities, CartTopSellers, CartNewReleases
     * @return string XML Response Document
     */
    function CartClear($responseGroup = "Cart")
    {
        $this->operation = "CartClear";
        $this->responseGroup = $responseGroup;

        $query_url = $this->make_url();
        $query_url .= "&CartId=" . $this->cartId;
        $query_url .= "&HMAC=" . $this->cartHMAC;

        $this->queryUrl = $query_url;

        return file_get_contents($this->queryUrl);
    } 

    /**
     * The CartModify operation allows you to change the amount of any item and even remove a item from the remote shopping cart.
     * 
     * Note: To remove an item from a shopping cart using CartModify, 
     * you must set its Quantity to 0.
     * 
     * If you want to modify multiple items at once, follow this scheme:
     * 
     * # $items[0]['cartItemId'] = 'U1VNNC69J87XSD';
     * # $items[0]['quantity'] = 3;
     * # $items[0]['action'] = false;
     * ...
     * 
     * Note: Quantity can be between 0 and 999. cartItemId and quantity is mandatory. 
     * action can be 'SaveForLater' or 'MoveToCart';
     * 
     * @link http://docs.amazonwebservices.com/AWSEcommerceService/2006-11-14/ApiReference/CartModifyOperation.html Amazon Docs for this Operation
     * @param array $cartItems An array of CartItemIds, their Quantity and (optional) Action
     * @param string $responseGroup Valid Groups: Cart, CartSimilarities, CartTopSellers, CartNewReleases
     * @return string XML Response Document
     */
    function CartModify($cartItems, $responseGroup = "Cart")
    {
        $this->operation = "CartClear";
        $this->responseGroup = $responseGroup;

        $itemNum = 0;
        $itemsString = "";

        foreach($cartItems as $item)
        {
            $itemNum++;
            $itemsString .= "&Item." . $itemNum . ".CartItemId=" . $item['cartItemId'];
            $itemsString .= "&Item." . $itemNum . ".Quantity=" . $item['quantity'];

            if ($item['action'])
            {
                $itemsString .= "&Item." . $itemNum . ".Action=" . $item['action'];
            } 
        } 
        $query_url = $this->make_url();
        $query_url .= "&CartId=" . $this->cartId;
        $query_url .= "&HMAC=" . $this->cartHMAC;

        $this->queryUrl = $query_url;

        return file_get_contents($this->queryUrl);
    } 
} 

/**
 * AmazonECS Customer Content Class
 * The customer content operations available in Amazon E-Commerce Service (ECS) 
 * allow you to search for and view customer-created content such as wish lists, 
 * Listmania lists, product reviews and any of the "About You" information a 
 * customer may have contributed to Amazon.
 * 
 * @author m3nt0r <mail@m3nt0r.de> 
 * @copyright Copyright (c) 2007, Kjell Bublitz
 * @version 0.1
 * @access public 
 */
class AmazonECS_Customer extends AmazonECS
{
    /**
     * Constructor
     */
    function AmazonECS_Customer()
    {
        $this->AmazonECS();
        $this->server = "webservices.amazon.com";
    } 

    /**
     * The ContentLookup operation allows you to retrieve publicly 
     * available content written by specific Amazon customers. Available data 
     * are limited to information about content customers have created for any 
     * Amazon Web site, including product reviews, Listmania lists, wish lists, 
     * registries, and reviewer rank.
     * 
     * Note: For reasons of confidentiality, CustomerContentLookup does not provide 
     * access to any customer account history or contact information (including email 
     * address, shipping address, billing address, or phone number).
     * 
     * Note: US only! (.com)
     * 
     * @link http://docs.amazonwebservices.com/AWSEcommerceService/2006-11-14/ApiReference/CustomerContentLookupOperation.html Amazon Docs for this Operation
     * @param string $customerId The Id of the customer you want to look up on
     * @param string $responseGroup Valid Groups: CustomerInfo, CustomerReviews, CustomerLists, CustomerFull
     * @param integer $reviewPage Allows you to page through a specified customer's reviews, ten at a time
     * @return string XML Response Document
     */
    function CustomerLookup($customerId, $responseGroup = "CustomerFull", $reviewPage = 0)
    {
        $this->operation = 'CustomerContentLookup';
        $this->responseGroup = $responseGroup;

        $query_url = $this->make_url();
        $query_url .= "&CustomerId=" . $customerId;

        if ($reviewPage)
        {
            $query_url .= "&ReviewPage=" . $reviewPage;
        } 
        $this->queryUrl = $query_url;

        return file_get_contents($this->queryUrl);
    } 

    /**
     * The CustomerContentSearch operation allows you to search for Amazon customers by name or email address.
     * 
     * Note: Amazon E-Commerce Service (ECS) only returns information that the customer has 
     * made public on the Amazon.com Web site. ECS never returns email addresses or mailing 
     * addresses regardless of whether or not the customer has made them public.
     * 
     * Note: US only! (.com)
     * 
     * @link http://docs.amazonwebservices.com/AWSEcommerceService/2006-11-14/ApiReference/CustomerContentSearchOperation.html Amazon Docs for this Operation
     * @param string $query Either real-name or e-mail address of a customer to get content from.
     * @param string $type Type of search method. Valid types: 'name' OR 'email'.
     * @param integer $customerPage Allows you to page through the list of customers in the response, 20 at a time. This parameter specifies the number of the page that will be returned by the request.
     * @return string XML Response Document
     */
    function CustomerSearch($query, $type = "name", $customerPage = 0)
    {
        $this->operation = 'CustomerContentSearch';
        $this->responseGroup = "Request,CustomerInfo";

        $type = strtolower($type);
        $query_url = $this->make_url();

        if ($customerPage)
        {
            $query_url .= "&CustomerPage=" . $customerPage;
        } 

        switch ($type)
        {
            case 'name':
                $query_url .= "&Name=" . urlencode($query);
                break;

            case 'email':
                $query_url .= "&Email=" . urlencode($query);
                break;
        } 

        $this->queryUrl = $query_url;

        return file_get_contents($this->queryUrl);
    } 
} 

/**
 * AmazonECS Lists Class
 * The Amazon E-Commerce Service (ECS) list operations allow you to search for 
 * and retrieve products and information from Wish Lists, Listmania Lists, Baby 
 * Registries, and Wedding Registries created on Amazon web sites.
 * 
 * @author m3nt0r <mail@m3nt0r.de> 
 * @copyright Copyright (c) 2007, Kjell Bublitz
 * @version 0.1
 * @access public 
 */
class AmazonECS_Lists extends AmazonECS
{
    /**
     * Constructor
     */
    function AmazonECS_Lists()
    {
        $this->AmazonECS();
        $this->server = "webservices.amazon.com";
    } 

    /**
     * The ListLookup operation allows you to retrieve all the products in a specific list. 
     * In addition to returning products, ListLookup allows you to retrieve general information 
     * about the list, such as the total number of products on the list and the list's creation date.
     * 
     * @link http://docs.amazonwebservices.com/AWSEcommerceService/2006-11-14/ApiReference/ListLookupOperation.html Amazon Docs for this Operation
     * @param string $listId The ID of the list to lookup
     * @param string $listType The Type. Valid are: Listmania, WishList, WeddingRegistry
     * @param string $responseGroup Valid are: ListFull, ListInfo, ListItems, ItemIds and more...
     * @param string $productSort Only for WishLists. Valid are: DateAdded, LastUpdated, Price
     * @param string $productGroup Only for WishLists. Valid are: DVD, Kitchen, Personal Computer, CE, Book, Sports and more...
     * @param string $productPage For pagination purpose. A page has 10 results. Maximum valid value is 30. Default is first page.
     * @param string $merchant Default is "Amazon". Valid are: All, Amazon, Featured, a known MerchantId
     * @param string $condition Default is "New". Valid are: All, New, Used, Refurbished, Collectible
     * @return string XML Response Document
     */
    function ListLookup($listId, $listType = "WishList", $responseGroup = "ListInfo", $page = 0, $merchant = "", $condition = "", $productGroup = "", $productSort = "")
    {
        $this->operation = "ListLookup";
        $this->responseGroup = $responseGroup;

        $query_url = $this->make_url();
        $query_url .= "&ListId=" . $listId;
        $query_url .= "&ListType=" . $listType;

        if ($listType == "WishList") // following only work with wishlists.
        {
            if ($productGroup)
            {
                $query_url .= "&ProductGroup=" . urlencode($productGroup);
            } 

            if ($productSort)
            {
                $query_url .= "&Sort=" . $productSort;
            } 
        } 

        if ($page && ($page >= 1 && $page <= 30))
        {
            $query_url .= "&ProductPage=" . $page;
        } 

        if ($merchant)
        {
            $query_url .= "&MerchantId=" . $merchant;
        } 

        if ($condition)
        {
            $query_url .= "&Condition=" . $condition;
        } 

        $this->queryUrl = $query_url;

        return file_get_contents($this->queryUrl);
    } 

    /**
     * The ListSearch operation allows you to search for a wish list, baby registry, or wedding registry.
     * 
     * Note: Your request must contain one of the following parameters when you are 
     * searching for wish lists or "wedding registries": Name, FirstName, LastName, 
     * and/or Email. If you include Name, it is not necessary to include FirstName 
     * and LastName and vice versa.
     * 
     * Note: Your request must contain one of the following parameters when you are 
     * searching for "baby registries": FirstName and/or LastName. The Name and Email 
     * parameters will be ignored when you are searching for BabyRegistry.
     * 
     * @link http://docs.amazonwebservices.com/AWSEcommerceService/2006-11-14/ApiReference/ListSearchOperation.html Amazon Docs for this Operation
     * @param string $query The value for type (a name, a email, etc..)
     * @param string $type Valid are: Name, FirstName, LastName, Email, City, State
     * @param string $listType The Type. Valid are: BabyRegistry, WishList, WeddingRegistry
     * @param string $responseGroup Valid are: ListMinimum, ListInfo, Request
     * @param integer $listPage Default is first page. Allows you to specify which page of results will be returned by the request. The ListPage parameter allows you page through lists in the response, 10 at a time.
     * @return string XML Response Document
     */
    function ListSearch($query, $type = 'Name', $listType = 'WishList', $responseGroup = "ListInfo", $listPage = 0)
    {
        $this->operation = "ListSearch";
        $this->responseGroup = $responseGroup;

        $query_url = $this->makeUrl();
        $query_url .= "&" . $type . "=" . urlencode($query);
        $query_url .= "&ListType=" . $listType;

        if ($listPage)
        {
            $query_url .= "&ListPage=" . $listPage;
        } 

        return file_get_contents($this->queryUrl);
    } 
} 

/**
 * AmazonECS Sellers Class
 * The Amazon E-Commerce Service (ECS) list operations allow you to search for 
 * and retrieve products and information from Wish Lists, Listmania Lists, Baby 
 * Registries, and Wedding Registries created on Amazon web sites.
 * 
 * @author m3nt0r <mail@m3nt0r.de> 
 * @copyright Copyright (c) 2007, Kjell Bublitz
 * @version 0.1
 * @access public 
 */
class AmazonECS_Sellers extends AmazonECS
{
    /**
     * Constructor
     */
    function AmazonECS_Sellers()
    {
        $this->AmazonECS();
        $this->server = "webservices.amazon.com";
    } 

    /**
     * The SellerLookup operation allows you to retrieve information about 
     * specific sellers, including customer feedback about the sellers, their 
     * average feedback rating, their location, etc. For reasons of confidentiality, 
     * SellerLookup will not return seller email addresses or business addresses.
     * 
     * @link http://docs.amazonwebservices.com/AWSEcommerceService/2006-11-14/ApiReference/SellerLookupOperation.html Amazon Docs for this Operation
     * @param mixed $sellerId Specify IDs for Amazon sellers you want to look up. Array for multiple IDs (Up to five). Else just the ID as String.
     * @param integer $page Optional. If more then 5 feedbacks exist you can page through all. Value may be between 1 and 10. (50 feedbacks max). Default is first page.
     */
    function SellerLookup($sellerId, $page = 0)
    {
        $this->operation = "SellerLookup";
        $this->responseGroup = "Request,Seller";

        $query_url = $this->make_url();

        if (is_array($sellerId))
        {
            $sellerString = "";
            foreach($sellerId as $seller)
            {
                $sellerString .= $seller . ",";
            } 
            $query_url .= "&SellerId=" . substr($sellerString, 0, strlen($sellerString)-1);
        } 
        else
        {
            $query_url .= "&SellerId=" . $sellerId;
        } 

        if ($page)
        {
            $query_url .= "&FeedbackPage=" . $page;
        } 

        $this->queryUrl = $query_url;

        return file_get_contents($this->queryUrl);
    } 

    /**
     * The SellerListingLookup operation allows you to request information about 
     * a seller's products, including product descriptions, condition information, 
     * and seller information. This operation only works with sellers who have 
     * less than 150,000 items for sale.
     * 
     * @link http://docs.amazonwebservices.com/AWSEcommerceService/2006-11-14/ApiReference/SellerListingLookupOperation.html Amazon Docs for this Operation
     * @param string $sellerId A single SellerID to get infos from. Valid Seller ID
     * @param string $id The item-id you wish to lookup. Valid: A listing ID, An Exchange ID
     * @param string $idType The type of seller listing. Optional. Valid: ASIN, SKU, Listing, Exchange
     * @return string XML Response Document
     */
    function SellerListingLookup($sellerId, $id, $idType = "")
    {
        $this->operation = "SellerListingLookup";
        $this->responseGroup = "Request,SellerListing";

        $query_url = $this->make_url();
        $query_url .= "&SellerId=" . $sellerId;
        $query_url .= "&Id=" . $id;
        $query_url .= "&IdType=" . $idType;

        $this->queryUrl = $query_url;

        return file_get_contents($this->queryUrl);
    } 

    /**
     * The SellerListingSearch operation enables you to search Marketplace listings. 
     * These sellers must have less than 150,000 items for sale. ECS does not 
     * support sellers that have more than 150,000 items
     * 
     * Note: SellerListingSearch cannot return listings for featured merchants' items. 
     * Only merchants with New, Used, Refurbished, and Collectible offerings are returned. 
     * To find items belonging to a specific featured merchant, use the ItemSearch operation, 
     * passing the merchant's ID in the MerchantId parameter.
     * 
     * Note: The SellerListingSearch operation in the FR, CA, and JP locales use a different 
     * set of operation parameters, which is described below.
     * 
     * @link http://docs.amazonwebservices.com/AWSEcommerceService/2006-11-14/ApiReference/SellerListingSearchOperation.html Amazon Docs for this Operation
     * @param string $sellerId A single SellerID to get infos from. Valid Seller ID
     * @param string $title Search for offer titles matching given word(s).
     * @param string $sort Optional. Valid: (+/-)startdate, (+/-)price, (-)enddate, (-)sku, (-)quantity, (-)title
     * @param integer $page Optional. Maximum value is 500. A page is up to 10 search results at a time. Page 1 = Result 1-10, Page 2 = Result 11-20, etc..
     * @param string $status Optional. Only for: US, UK, DE. Default is: "Open". Valid are: Open, Closed
     * @return string XML Response Document
     */
    function SellerListingSearch($sellerId, $title, $sort = "", $page = 0, $status = "")
    {
        $this->operation = "SellerListingLookup";
        $this->responseGroup = "Request,SellerListing";

        $query_url = $this->make_url();
        $query_url .= "&SellerId=" . $sellerId;
        $query_url .= "&OfferStatus=" . $status;

        if ($title)
        {
            $query_url .= "&Title=" . urlencode($title);
        } 
        if ($sort)
        {
            $query_url .= "&Sort=" . $sort;
        } 
        if ($status)
        {
            $query_url .= "&OfferStatus=" . $status;
        } 
        if ($page)
        {
            $query_url .= "&ListingPage=" . $page;
        } 

        $this->queryUrl = $query_url;

        return file_get_contents($this->queryUrl);
    } 
} 

/**
 * This service is not free, so i cant go on with it.. :(
 * 
 * @author m3nt0r <mail@m3nt0r.de> 
 * @copyright Copyright (c) 2007, Kjell Bublitz
 * @version 0.1
 * @access public 
 */
class AmazonAlexaWebInfo extends Amazon
{
    /**
     * Constructor
     */
    function AmazonAlexaWebInfo()
    {
        $this->Amazon();
        $this->server = "awis.amazonaws.com";
        $this->service = "AlexaWebInfoService";
        $this->use_signatureAuth = true;
    } 

    function UrlInfo($site_url, $responseGroup)
    {
        $this->operation = "UrlInfo";
        $this->responseGroup = $responseGroup;

        $query_url = $this->make_url();
        $query_url .= "&Url=" . urlencode($site_url);

        $this->queryUrl = $query_url;

        return file_get_contents($this->queryUrl);
    } 
} 
?>