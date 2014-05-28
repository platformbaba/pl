source ./deploy.properties


if [ -d "$TOMCAT_DEPLOYMENT_DIRECTORY" ]; then
        echo "copying solr war to tomcat"
        cp ./dist/solr-4.5.1.war $TOMCAT_DEPLOYMENT_DIRECTORY
        echo "done...."
fi



if [ -d "$SOLR_HOME" ]; then
        echo "copying configurations to solr home :-- $SOLR_HOME"
        cp -R ./cores $SOLR_HOME/
        cp -R ./solr_lib $SOLR_HOME/
        cp ./solr.xml $SOLR_HOME/
        echo "done...."
fi
