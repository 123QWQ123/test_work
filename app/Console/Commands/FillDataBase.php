<?php

namespace App\Console\Commands;

use App\Car;
use App\Colors;
use App\Grades;
use DB;
use Illuminate\Console\Command;

class FillDataBase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fill:db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'You can fill out the database only once per clean database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (Car::all()->isNotEmpty()) {
            $this->info('Таблица уже загружена данными!');

            return;
        }

        $jsonData = json_decode(file_get_contents('http://toyota-credit.360d.ru/cars/Models/all.json'));

        array_filter($jsonData, function ($car) {
            $propertiesObject = current($car);

            $carId = $propertiesObject->id ?? null;
            $carTitle = $propertiesObject->title ?? null;
            $carSprite = $propertiesObject->sprite ?? null;
            $carImage = $propertiesObject->image ?? null;
            $carLink = $propertiesObject->link ?? null;

            if ($propertiesObject) {
                DB::beginTransaction();
                try {
                    $newCar = new Car();
                    $newCar->id = $carId;
                    $newCar->title = $carTitle;
                    $newCar->sprite = $carSprite;
                    $newCar->image = $carImage;
                    $newCar->link = $carLink;
                    $newCar->save();

                    $preparedData = $this->prepareGradesAndColorsToSave($propertiesObject->grades, $carId);
                    Grades::insert($preparedData['grades']);
                    Colors::insert($preparedData['colors']);

                    DB::commit();
                } catch (\ErrorException $exception) {
                    DB::rollback();
                    $this->info('Откат данных! Ошибка' . $exception->getMessage());
                }
            }
        });
        $this->info('Таблица пользователей загружена данными!');
    }

    /**
     * Prepare grades and colors to save in DB
     *
     * @param array $grades
     * @param string $carId
     *
     * @return array
     */
    private function prepareGradesAndColorsToSave(array $grades, string $carId)
    {
        $data = [
            'grades' => [],
            'colors' => [],
        ];

        foreach ($grades as $grade) {
            $data['grades'][] = [
                'title' => $grade->title,
                'id' => $grade->id,
                'engine_desc' => $grade->engine_desc,
                'wheel_drive' => $grade->wheeldrive,
                'price' => $grade->price,
                'price_discount' => $grade->pricediscount,
                'engine' => $grade->engine,
                'transmission' => $grade->transmission,
                'body' => $grade->body,
                'features' => json_encode($grade->features),
                'specifications' => json_encode($grade->technicalSpecification),
                'car_id' => $carId,
            ];

            foreach ($grade->colors as $color) {
                $data['colors'][] = [
                    'id' => $color->id,
                    'rgb' => $color->rgb,
                    'code' => $color->code,
                    'title' => $color->title,
                    'type' => $color->type,
                    'price' => $color->price,
                    'swatch' => $color->swatch,
                    'image' => $color->image,
                    'grade_id' => $grade->id,
                ];
            }
        }

        return $data;
    }
}
