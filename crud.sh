#!/bin/bash

arr=("Crm\AdminProperties" "Crm\Contact" "Crm\EmailTemplate" "Crm\Invoice" "Crm\JobProperties" "Crm\Note" "Crm\Service" "Crm\TaxRate" "Crm\Business" "Crm\Email" "Crm\File" "Crm\Job" "Crm\Lead" "Crm\Quote" "Crm\Task" "Crm\User")

# for loop that iterates over each element in arr
for i in "${arr[@]}"
do
IFS='\' read -ra array <<< "$i"

dir="${array[0]}"
capsdir=foo="$(tr '[:lower:]' '[:upper:]' <<< ${dir:0:1})${dir:1}"
if ${#array[@]} -gt 1 
then
	dir="${array[0]}"/"${array[1]}"
fi
# created: src/Controller/Crm/UserController.php
# created: src/Form/Crm/UserType.php
# created: templates/crm/user/_delete_form.html.twig
# created: templates/crm/user/_form.html.twig
# created: templates/crm/user/edit.html.twig
# created: templates/crm/user/index.html.twig
# created: templates/crm/user/new.html.twig
# created: templates/crm/user/show.html.twig

    php bin/console make:crud "$i"
done
