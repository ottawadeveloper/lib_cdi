Drupal 7 introduced Entities as common data storage for any type of content.
However, due to varying requirements, not every type of data uses Entities 
(most Exportables for example). In addition, entities was only ever designed
for use with content - configuration data is still managed separately.

What CDI aims to do is to define operations that are common to any type of data
(such as import, export, etc). By providing a data-type agnostic interface for
these operations, CDI can be used to work with any type of data in Drupal that
implements the interface, without requiring that the data be an Entity, a 
properly Exportable table or otherwise. 

We hope this module will become a useful tool that developers can use when they
want to manipulate numerous different datatypes, such as what Features, Migrate,
Deploy, Default Content, Default Config, Feeds and others are doing. With this
interface, those modules and ones like them would no longer have to provide 
their own plugin system and contrib modules that provide data would no longer
have to adhere to any particular patterns or implement multiple different
handlers for these very similar tasks - instead, they would only have to 
implement the CDI controller and many different types of apps could leverage
the data.

CDI API:

object id() Returns a local identifier for the object
object uuid() Returns a universal identifier for the object, if available
static id(identifier) Returns the local identifier for the object
static uuid(identifier) Returns the universal identifier for the object
static id(datatype, identifier) Constructs a local identifier for the object
static uuid(datatype, identifier) Constructs a universal identifier for the object