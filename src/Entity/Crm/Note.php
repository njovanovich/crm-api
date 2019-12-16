<?php
/**
 * Note.php
 * Created by: nick
 * @ 11/12/2019 3:34 PM
 * Project: crm
 *
 * Copyright © 2019 Total Business Information Solutions Pty Ltd
 *
 */


namespace App\Entity\Crm;

use App\Entity\Document;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Lead
 * @package App\Entity\Crm
 * @ORM\Entity()
 * @ORM\Table("notes")
 */
class Note extends Document
{

    protected $type = 'note';

}