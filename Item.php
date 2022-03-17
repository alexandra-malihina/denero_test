<?php

/**
 * getObject
 *
 * @param  int $id
 * @return array
 */
function getObject(int $id)
{
    return [
        'status' => 2,
        'name' => 'name_item'
    ];
}


/**
 * setObject
 *
 * @param  mixed $data
 * @param  int $id
 * @return void
 */
function setObject($data, int $id)
{

}

final class Item {

    /**
     * The object key
     * 
     * @var int
     */
    private $id;

    // /**
    //  * Имя объекта
    //  * 
    //  * @var string
    //  */
    // private $name = '';

    // /**
    //  * Статус объекта
    //  * 
    //  * @var int
    //  */
    // private $status = 0;

    /**
     * Свойство объекта
     * 
     * @var bool
     */
    private $changed = false;

    
    /**
     * Сырые данные из бд
     *
     * @var array
     */
    private $original = [];
    
    /**
     * Данные для перегрузки
     *
     * @var array
     */
    private $data = [];
    

    public function __construct (int $id)
    {
        $this->id = $id;
        $this->init();
    }
    
    /**
     * init
     *
     * @return void
     */
    protected function init()
    {
        if (empty($this->original))
        {
            $this->original = getObject($this->id);

            foreach ($this->original as $key => $value)
            {
                $this->data[$key] = $value;
            }
            
            // $this->status = $this->original['status'];

            // $this->name = $this->original['name'];
            
        }

    }
    
    /**
     * __get
     *
     * @param  mixed $name
     * @return void
     */
    public function __get($name)
    {
        return $this->data[$name] ?? NULL;
    }
    
    /**
     * __set
     *
     * @param  mixed $name
     * @param  mixed $value
     * @return void
     */
    public function __set($name, $value)
    {
        if ($name != 'id' && isset($this->data[$name]))
        {
            if (gettype($this->data[$name]) === gettype($value))
            {
                $this->data[$name] = $value;
            }
        }
    }

    
    /**
     * save
     *
     * @return void
     */
    public function save()
    {
        foreach($this->data as $key => $value)
        {
            if ($value !== $this->original[$key])
            {
                $this->changed = true;
                break;
            }
        }

        if ($this->changed)
        {
            setObject($this->data, $this->id);
            $this->changed = false;
        }
    }
}
