ZF2F Class Notes: Course Version 2-2

-----------------------------------------------------------------------------------------------
VM ISSUES:
-----------------------------------------------------------------------------------------------
1. GD Extension missing: 
   sudo apt-get install php7.1-gd 
2. intl Extension missing:
   sudo apt-get install php7.1-intl
3. Restart apache (and php):
   sudo service apache2 restart
4. Could not import projects into Zend Studio
   Had to manually create .project files and import 

-----------------------------------------------------------------------------------------------
onlinemarket.complete ISSUES:
-----------------------------------------------------------------------------------------------

cd /home/vagrant/Zend/workspaces/DefaultWorkspace/onlinemarket.complete
mkdir public/captcha
sudo chown -R www-data:vagrant public/captcha

-----------------------------------------------------------------------------------------------
onlinemarket.work ISSUES:
-----------------------------------------------------------------------------------------------

// do not want a directory "onlinemarket.work" as this will be created as part of the project
cd /home/vagrant/Zend/workspaces/DefaultWorkspace
mv onlinemarket.work onlinemarket.start


-----------------------------------------------------------------------------------------------
COURSE MATERIALS UPDATES
-----------------------------------------------------------------------------------------------
http://zf2f.course/#/2/4
-- should reference ZF2 + ZF3 not just ZF2
http://zf2f.course/#/2/5: 5 elements!
http://zf2f.course/#/2/15: autoload_classmap.php + generator specific to ZF2
http://zf2f.course/#/2/18: remove ref to ZF2
http://zf2f.course/#/2/24: there was no discussion on routing (????)
http://zf2f.course/#/3/1: outline is the same as prev module
                        : need to either say ZF2/ZF3 or just get rid of ZF2
http://zf2f.course/#/3/9: should have ZF2 / ZF3 module structures side by side
http://zf2f.course/#/3/10: title s/be application config files or something like that
http://zf2f.course/#/3/11: or include modules.config.php
http://zf2f.course/#/3/27: s/be "BasePath"
http://zf2f.course/#/3/30: 1st example should show &lt; etc.
http://zf2f.course/#/4/6: FlashMessenger is not included with ZF3 by default
http://zf2f.course/#/4/10: missing router => routes => ´login´ 
http://zf2f.course/#/4/23: need to mention setters on response object
http://zf2f.course/#/4/25: did not mention what is $event!!!
http://zf2f.course/#/5/11: this syntax doesn´t work in ZF3
http://zf2f.course/#/6/21: summary does not match content
http://zf2f.course/#/7/3: need to provide (at least a partial) list of form elements
http://zf2f.course/#/7/36: rewrite for array access
http://zf2f.course/#/8/3: not ¨built on top of PDO¨ ; modeled after PDO
http://zf2f.course/#/8/12: need to run ->select() 
http://zf2f.course/#/8/33: does QUERY_MODE_EXECUTE produce results???
http://zf2f.course/#/8/43: s/be Zend\Db\TableGateway\Feature\*
http://zf2f.course/#/8/48: summary doesn´t match contents
http://zf2f.course/#/9/12: doesn´t really make a lot of sense!!!
http://zf2f.course/#/9/22: GlobalEventManager removed from ZF3
http://zf2f.course/#/9/23: no lab!!!
http://zf2f.course/#/10/12: should finish discussing module cycle before discussing MVC
http://zf2f.course/#/10/16: adds to the MvcEvent, not the EventManager
http://zf2f.course/#/10/21: duplication of previous course module on EventManager???
http://zf2f.course/#/11/10: code example missing closing parenthesis

-----------------------------------------------------------------------------------------------
LAB NOTES:
-----------------------------------------------------------------------------------------------
Module 1 Lab:
1. edit .project file
2. change <name>to match project
3. save as /home/vagrant/Zend/workspaces/DefaultWorkspace/xxx
4. Do that for all 3 projects

From Zend Studio:
1. File - Import - General - Existing projects into workspace
2. Specify /home/vagrant/Zend/workspaces/DefaultWorkspace
3. Click Finish

Skeleton .project file:

<?xml version="1.0" encoding="UTF-8"?>
<projectDescription>
    <name>onlinemarket.complete</name>
    <comment></comment>
    <projects>
    </projects>
    <buildSpec>
        <buildCommand>
            <name>org.eclipse.wst.jsdt.core.javascriptValidator</name>
            <arguments>
            </arguments>
        </buildCommand>
        <buildCommand>
            <name>org.eclipse.wst.validation.validationbuilder</name>
            <arguments>
            </arguments>
        </buildCommand>
        <buildCommand>
            <name>org.eclipse.dltk.core.scriptbuilder</name>
            <arguments>
            </arguments>
        </buildCommand>
    </buildSpec>
    <natures>
        <nature>org.zend.php.framework.ZendFrameworkNature</nature>
        <nature>org.eclipse.php.core.PHPNature</nature>
        <nature>org.eclipse.wst.jsdt.core.jsNature</nature>
    </natures>
</projectDescription>

Module 2 Lab: Create Your First Module
-- Since no route is defined, students do not see any output!
-- The controller is not recognized because we have not discussed how to add its configuration
Lab: Updating the Routing Table
-- Does not mention how to acquire the parameter from the route
-- Parameters are not addressed in the presentation

-----------------------------------------------------------------------------------------------
Q & A
-----------------------------------------------------------------------------------------------
Q: How do you change the default extension for view templates?
A: In module.config.php:
   'view_manager' => ['default_template_suffix' => 'php']
   
Q: Where is the migration guide showing diffs betw/ ZF2 and ZF3
A: https://zendframework.github.io/zend-servicemanager/migration/

Q: What is meant by this: ¨$reuseMatchedParams¨	Whether to reuse matched parameters¨?
A: When you're on a route that has many parameters, often times it makes sense to reuse currently 
   matched parameters instead of assigning them new explicitly. In this case, the argument 
   $reuseMatchedParams will come in handy.  As an example, we will imagine being on a detail page for 
   our "news" route. We want to display links to the èdit and delete actions without having to assign the ID again.
   See: https://github.com/fahdi/zf3-documentation/blob/master/docs/src/modules/zend.view.helpers.url.rst
   
Q: Can you show an example of fluent interface in Zend\Db\Sql?

Q: Can you produce an example of a subquery using Zend\Db\Sql?

Q: Where is an example of using Doctrine with ZF2?

