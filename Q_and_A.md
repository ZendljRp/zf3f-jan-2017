#Zend Framework 3 Q & A

##Q & A
- Q: How do you change the default extension for view templates?
- A: In module.config.php:
```
'view_manager' => [
    'default_template_suffix' => 'php'
]
```

- Q: Where is the migration guide showing diffs betw/ ZF2 and ZF3
- A: https://zendframework.github.io/zend-servicemanager/migration/

- Q: What is meant by this: ¨$reuseMatchedParams¨	Whether to reuse matched parameters¨?
- A: When you're on a route that has many parameters, often times it makes sense to reuse currently
   matched parameters instead of assigning them new explicitly. In this case, the argument
   $reuseMatchedParams will come in handy.  As an example, we will imagine being on a detail page for
   our "news" route. We want to display links to the èdit and delete actions without having to assign the ID again.
   See: https://github.com/fahdi/zf3-documentation/blob/master/docs/src/modules/zend.view.helpers.url.rst

- Q: Can you show an example of fluent interface in Zend\Db\Sql?
- A: See below
```
$platform = new Mysql();
$select = new Select();
$where = new Where();
$where->like('city', '%salt%');
$where->nest->like('city', '%lake%')->or->like('city', '%wood%')->unnest;

$select->from('names')
       ->columns(array('fn' => 'first_name', ln => 'last_name', 'city'))
       ->where($where);
echo $select->getSqlString($platform);

// Outputs:
// SELECT `names`.`first_name` AS `fn`, `names`.`last_name` AS `ln`,
// `names`.`city` AS `city` FROM `names` WHERE `city` LIKE '%salt%' AND
// (`city` LIKE '%lake%' OR `city` LIKE '%wood%')
```

- Q: Can you produce an example of a subquery using Zend\Db\Sql?
- A: This is from an extremely early version of the Online Market app, Market\Model\ListingsTable
```
// Produces:
// SELECT * FROM `listings` WHERE `listings_id` IN (SELECT MAX(`listings_id`) FROM `listings`)
public function getLatestListing()
{
    $adapter = $this->getAdapter();
    $platform = $adapter->getPlatform();
    $quoteId = $platform->quoteIdentifier($this->listingsId);
    $select = new Select();
    $select->from(self::$tableName);
    $expression = new Expression(sprintf('MAX(%s)', $quoteId));
    $subSelect = new Select();
    $subSelect->from(self::$tableName)->columns(array($expression));
    $where = new Where();
    $where->in($this->listingsId, $subSelect);
    $select->where($where);
    return $this->selectWith($select)->current();
}
```

- Q: Where is an example of using Doctrine with ZF2?
- A: See: https://github.com/dbierer/demystifying-doctrine

- Q: How do you implement transaction support?
- A: The proper way to Begin, Commit, and Rollback Transactions is as follows:
```
$this->getAdapter()->getDriver()->getConnection()->beginTransaction();
$this->getAdapter()->getDriver()->getConnection()->commit();
$this->getAdapter()->getDriver()->getConnection()->rollback();
```
    You can also get the Last ID created by:
```
    $this->getAdapter()->getDriver()->getConnection()->getLastGeneratedValue()
```
   See: http://stackoverflow.com/questions/13831582/how-does-zend-db-in-zf2-control-transactions

- Q: What is the difference between ZF2 and ZF3?
- A: As of ZF2.5 there is no difference between ZF2 and ZF3!
