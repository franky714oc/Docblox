Configuration
=============

DocBlox is meant as a highly configurable and extensible
application. As such there are a lot of things that can be
configured by the user.

An overview will be given in this chapter where you could place the
configuration file and what it needs to look like.

Location
--------

The easiest solution would be to place the configuration file in
the root of your project with the name: ``docblox.dist.xml``. This
file can be committed to a Revision Control System and thus will
the settings always be available.

When you have added a configuration file then you do not need to
provide its location to DocBlox; the following command suffices to
build your documentation:

::

    $ docblox

An additional benefit is that it is possible for each developer to
place a file called ``docblox.xml`` in their project, in addition
to the ``docblox.dist.xml``. This configuration file will be used
instead of the ``docblox.dist.xml`` and when added as an ignore
rule in your VCS it will give developers the ability to have
settings other than the project defaults.

    **Note:**
    *the file ``docblox.xml`` is used instead of ``docblox.dist.xml`` and thus does not supplement it*


Another option is to use the ``-c`` or ``--configuration``
arguments to tell DocBlox the location of your configuration file.
This can be convenient for centralized configuration management or
using different settings per environment.

    **Note:** ``none`` is a reserved word and providing ``-c none`` as
    option will result in any configuration file being ignored.


Basic configuration
-------------------

DocBlox follows the *convention over configuration* style and as
such it is only necessary to specify the options which you want to
change with regard to the defaults.

The easiest way to find out what the defaults are is to look in the
configuration template, which is located in
*[DOCBLOX FOLDER]/data/docblox.tpl.xml* or to examine the
specifications in this document.

Usually the following configuration suffices for your project:

::

    <?xml version="1.0" encoding="UTF-8" ?>
    <docblox>
      <parser>
        <target>data/output</target>
      </parser>
      <transformer>
        <target>data/output</target>
      </transformer>
      <files>
        <directory>.</directory>
      </files>
    </docblox>

*Remember when we told you about there being a parser and transformer in the previous chapter?*
The configuration expects you to specify for both what their output
(target) folder should be.

    This way it is possible to provide a staging location where you
    indefinitely store your structure file and benefit from the
    increased speed when doing multiple runs. This is called
    **Incremental Processing** or **Incremental Parsing**.


The transformer expects the source file to be at the target
location of the parser so you need not specify that explicitly.

The files section allows you to specify where the source code for
your project is.

::

      <files>
        <file>test.php</php>
        <file>bin/*</php>
        <directory>src</directory>
        <directory>tes??</directory>
      </files>

It is allowed to use relative paths here; just remember that these
are relative from the working directory where you execute DocBlox
in.

It is possible to specify specific files or a specific set of files
using the element. As with the -f parameter it supports wildcards.

In addition you can also provide entire directory trees using the
element. This also supports the use of wildcards. Please note that
in contrary to the element that the element is recursive and will
tell DocBlox to process all files contained in this folder and
every subfolder.

Reference
---------

The DocBlox configuration file contains the following top level
elements which are explained in more detail in the sub-chapters.


-  Title, the title for this project, *may contain HTML*
-  Parser, all settings related to the conversion of the source
   code to the intermediate structure file (structure.xml).
-  Transformer, all settings related to the process of transforming
   the intermediate structure file (structure.xml) to a human readable
   format, such as HTML or PDF.
-  Logging, all settings related to the generation of logs.
-  Transformations, the default template and additional
   transformations can be specified in this section.

Parser
~~~~~~

The parser section contains all settings related to the conversion
of your project's source to the intermediate structure format of
DocBlox (structure.xml).

The following fields are supported:


-  *target*, the target location where to store the structure.xml,
   also used as source location for the transformer.
-  *markers*, contains a listing of item's. These items identify
   which keywords in comments are used to identify additional sets of
   information. An example of this is inline comments starting with
   the *marker* TODO or FIXME.
-  *extensions*, contains a list of extension's which a file
   must have to be interpreted. If a file does not have the extension
   mentioned in this list then it is not parsed. Examples: php, php3
   or phtml.

*Example*

::

    <parser>
      <target>output</target>
      <markers>
        <item>TODO</item>
        <item>FIXME</item>
      </markers>
      <extensions>
        <extension>php</extension>
        <extension>php3</extension>
        <extension>phtml</extension>
      </extensions>
    </parser>

Transformer
~~~~~~~~~~~

The transformer section contains most settings related to the
transformation of the intermediate structure format (structure.xml)
to a human-readable set of documentation. The format of this set of
documentation is determined by the template choice which is present
in the ``transformations`` head section.

    The transformer determines the location of the intermediate
    structure format (structure.xml) by retrieving the ``target``
    element in the ``parser`` section.


The following fields are supported:


-  *target*, the target location where to store the generated
   documentation files.

*Example*

::

    <transformer>
      <target>output</target>
    </transformer>

Logging
~~~~~~~

The logging section contains all settings related to the logging of
information in DocBlox.

    DocBlox does not 'care' whether the specified logging paths exist;
    if they do not then no log files are generated.


The following fields are supported:


-  *level*, determines the minimum level of information that is
   supplied. Any priority equal to or higher than the given is
   included in the log files and is output to the screen. All
   priorities lower than the given are not logged. The following
   values are allowed (in order from highest to lowest priority):

   - emerg
   - alert
   - crit
   - err
   - warn
   - notice
   - info
   - debug
   - quiet

-  *paths*, contains all folders to where DocBlox may log.
-  *default*, this is the path of the default logging file, the
   name may be augmented with a {DATE} variable to provide a
   timestamp and {APP_ROOT} to indicate the root of the DocBlox application.
-  *errors*, messages with level *debug* are not added to the
   default log but in a separate log file whose path you can declare
   here. As with the *default* log file you can augment the path with
   the {DATE} variable.

*Example*:

::

    <logging>
        <level>warn</level>
        <paths>
            <default>{APP_ROOT}/data/log/{DATE}.log</default>
            <errors>{APP_ROOT}/data/log/{DATE}.errors.log</errors>
        </paths>
    </logging>

Transformations
~~~~~~~~~~~~~~~

The transformations section controls the behaviour applied in
transforming the intermediate structure format to the final human-readable
output.

The following fields are supported:

- *template*, the name or path of a template to use. This element may be used
  multiple times to combine several templates though usually you only supply one.
  Example:

  ::

      <template name="default"/>

  ::

      <template name="/home/mvriel/Docblox Templates/myTemplate"/>

- *transformation*, it is also possible to execute additional transformations
  specifically for this project by defining your own transformations here.
  See the chapter on :doc:`Building your own branding` for a description of the
  transformation element and examples.

*Example*:

::

    <transformations>
        <template name="default" />
    </transformations>

Appendix A: basic configuration example
---------------------------------------

::

    <?xml version="1.0" encoding="UTF-8" ?>
    <docblox>
      <parser>
        <target>data/output</target>
      </parser>
      <transformer>
        <target>data/output</target>
      </transformer>
      <files>
        <directory>.</directory>
      </files>
    </docblox>

Appendix B: complete configuration example
------------------------------------------

::

    <?xml version="1.0" encoding="UTF-8" ?>
    <docblox>
        <parser>
            <target>output</target>
            <markers>
                <item>TODO</item>
                <item>FIXME</item>
            </markers>
            <extensions>
                <extension>php</extension>
                <extension>php3</extension>
                <extension>phtml</extension>
            </extensions>
            <visibility></visibility>
        </parser>
        <transformer>
            <target>output</target>
        </transformer>
        <logging>
            <level>warn</level>
            <paths>
                <default>{APP_ROOT}/data/log/{DATE}.log</default>
                <errors>{APP_ROOT}/data/log/{DATE}.errors.log</errors>
            </paths>
        </logging>
        <transformations>
            <template name="default" />
        </transformations>
    </docblox>