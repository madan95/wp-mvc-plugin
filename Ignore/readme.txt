                                                                                            PCA Job Booking Plugin

File and Folder Structure ::

--> index.php  (main plugin initiator )
--> bootstrap.php (includes javascript and css needed for plugin)

--> core
       --- controller
                --MainController.php  (Is Front Facing class that will handle all request and redirect request to its specific controller-action)
                --controller (Methods that always take in 2 variable $_get/$_post and model , it is these action that execute model methods to get result and choose a view to return back to user)
       --- model
                (Only using Model atm, might make other class inherit Model / ignore other model than Model.php for now)
                (Model class does all data handling with Database)
       --- view
               --css :: (Contains bootstrap and custom style.css)
               --js  :: (Contains jquery/bootstrap and custom js which handles all the ajax from client side)
            --- view.php (This class is contains methods that will create view by taking in data/results from model)

       --- helper
                -- util.php (used by view when creating form, it has reference value for database data-type which will create from type according to data-type passed to it's method)


P.S:: Not initial database creation atm, Have to create database manually for now.


**********************************************************************************************************************************************************************************************************************

To Use it in Wordpress::

Just put in shortcode::

    [view_page page = location action = lists]

change location to another table name
At the Moment, action for shortcode is only lists, could add grant char or other action in future


**********************************************************************************************************************************************************************************************************************
