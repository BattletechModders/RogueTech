The mod is created to expand the mechanics of pilot upgrades. Pilot can receive abstract experience, but also specific experience associated with specific actions.
Particularly by shooting weapons.
It is possible to define "expertises" - entities in which a pilot gains experience

These entities are described in a custom resource PilotWeaponLevelingDef


{
  "Description": {                                     - standard description there are no special features here, except that UIName must be specified
                                                         in the user interface it will be used, if it is not specified Name WILL NOT be used
                                                         and you will get empty lines in the interface
    "UIName": "Ballistic",
    "Id": "pilotweaponlevelingdef_Ballistic",
    "Name": "ballistic leveling",
    "Details": "Ballistic Leveling",
    "Icon": "weapon_omni"
  },
  "HeaderChar": "B",                                  - There should be only one character, used when it is necessary to show "expertise" data in the most short form
  "Color":"#CCCC00",                                  - color for text, in those places of the interface where it is appropriate this color for text will be used
  "levels": [                                         - list of levels that can be achieved in a given class. 
	{
  	  "experience": 0,                                - experience points need to be gained to get this level
	  "Color": "yellow",                                - color for text, in those places of the interface where it is appropriate this color for text will be used
	  "HeaderChar": "0",                                - There should be only one character, used when it is necessary to show "level" data in the most short form
	  "progression": [                                  - information about how much experience a pilot will receive when firing a weapon at a given level of experience
	  	  { 
					"chance": 0,                                - to-hit chance
					"fail_exp": 10,                             - exp gained if missed
					"success_exp":20                            - exp gained if hits
				},
	  	  { "chance": 0.25, "fail_exp": 8, "success_exp":16 },
	  	  { "chance": 0.50, "fail_exp": 6, "success_exp":12 },
	  	  { "chance": 0.75, "fail_exp": 4, "success_exp":8 },
								NOTE:
								It works like this - after an attack with a given type of weapon (not a shot, but an attack, guns making many rolls to hit per salvo have no advantage),
								a search is made in this array for a record with chance with the highest value, but less than the current effective chance of a hit from a given weapon.
								The percentage of bullets that hit somewhere is calculated (no matter the target that was aimed at or not), without taking into account area damage (which always hits)
								Based on the percentage of bullets that hit, the point between the “amount of experience on a miss” and the “amount of experience on a hit” is calculated and this amount of experience is added to the pilot in a given “expertise” class.
								For example: you shoot with a rotary LBX5 in x3 mode, with a chance of 53%. According to the table, your entry is "chance": 0.50, "fail_exp": 6, "success_exp":12
								A total of 5x3 = 15 bullets were fired, let's assume 10 of them hit. The pilot will receive experience points (12 - 6) * (10/15) + 6 = 10 experience points.
								When the amount of experience for a certain level is reached, the actual application of bonuses will only be made in the next battle, however, experience points will be accrued
								in accordance with the rules of a new level, this is not a mistake, this was done on purpose.
								The developer's conceptual idea about the balance of leveling is that at low levels of experience the pilot should receive a sufficient amount of experience even if he misses,
								however, at high levels and with high chances of hitting, the amount of experience gained should decrease - it should be easy to level up to some average level of proficiency,
								further progress must be significantly slowed down.
								
								
	  "levelDef":"" - identifier of the UpgradeDef component, which serves as a container for bonuses provided by a given level of weapon proficiency. May be empty.
										A good idea would be to create a component with debuffs for low levels of weapon proficiency.
										When a unit is initialized, a component of this type will be added to it in location 0 (None), i.e. the component will be virtually indestructible
										The only peculiarity is that the abilities added by the component will be added as pilot abilities, and not in the weapons panel
										as is done for regular ability-adding components.
    },
	{
  	  "experience": 1000,
	  "Color": "green",
	  "HeaderChar": "1",
	  "progression": [
	  	  { "chance": 0, "fail_exp": 8, "success_exp":16 },
	  	  { "chance": 0.25, "fail_exp": 6, "success_exp":12 },
	  	  { "chance": 0.50, "fail_exp": 4, "success_exp":8 },
	  	  { "chance": 0.75, "fail_exp": 2, "success_exp":4 },
	  ],
	  "levelDef":"weaponleveldef_Ballistic_1"
    }
  ]
}

UI:

In the summary view, the raft's experience is displayed instead of the pilot's expertise line (recruit, veteran, etc.) this line has now been replaced with
string like "<leveling1.HeaderChar><level.HeaderChar> <leveling2.HeaderChar><level.HeaderChar> ..."\

Mod settings

	"defaultGenerator":{   - default expertise generator, look Leveling generators section
		"id":"default", "experience_min": 0, "experience_max": 2000, "experience_cap_min":1000, "experience_cap_max": 4000
	},
	"ChangedChar":"^",     - this char will be added to short pilot expertise string if level been changed
	"ChangedCharColor":"yellow", - color for char above
	"ChangedColor":"#C1FF33FF",  - background color flashed if level been changed
	"LevelingBackColor":"#3366FF", - background color for expertise info popup
	"LevelNotSelectedBackColor":"#808080", - background color for level UI item if this level is NOT current for pilot
	"LevelSelectedBackColor":"#008000" - background color for level UI item if this level is current for pilot
	
	
Leveling generators

you can set pilot expertise in PilotDef, add section to a json

"WeaponsProgression" : {
	"progression": {
		"pilotweaponlevelingdef_Ballistic": - expertise if
		{
			"experience": 234, - current exp level
			"experience_cap": 2000 - max exp level in this expertise
		}
	}
}

If the pilot does not have a definition of experience level in any expertise class or if the pilot is randomly generated
The current experience level and maximum level will be generated randomly.
To control this process, it is possible to create so-called. generators
Generator entity described by a custom class WeaponProgressionGenerator

{
	"id": "generator",  - identifier
	"experience_min": 0, - min currect exp
	"experience_max": 2000, - max currect exp
	"experience_cap_min": 0, - min exp cap
	"experience_cap_max": 2000, - max exp cap
	"systemTags": [], - star system tags
	"pilotTags": [], - pilot tags
	"levelings": [] - levelings (expertises) list
}

If a pilot needs to generate expertise in any class, a search is made among all available generators
According to the following criteria
1. If the generator's systemTags is not empty and the context of the star system makes sense, then the system must have all the tags specified in the generator definition
2. If the generator pilotTags is not empty, the pilot must have all the tags specified in the generator definition
3. If the levelings generator is not empty, the examination class identifier must be present in the list of levelsings

If all these three conditions are met - the generator is considered suitable - the first suitable generator is selected, the generators are sorted in an unpredictable manner,
Therefore, it is a good idea to define disjoint generators. A generator with empty systemTags, pilotTags and levelings will be considered suitable in all cases.
If a suitable generator was not found, the generator defined in the defaultGenerator of the mod settings will be used.

Connection between weapon and expertise

Each weapon can only have one expertise class. It is defined as follows: a tag is searched among weapon tags
with the name "progression_type_<expertise identifier suffix>", if such a tag is found, a search is made for the expertise class with the identifier "pilotweaponlevelingdef_<expertise identifier suffix>"
If expertise with such an identifier is found, this class is considered the expertise class for this weapon.
If the search by tags failed, the expertise class is searched for by weapon category.
A search is made for the expertise class with the identifier "pilotweaponlevelingdef_<weapon category>".
If expertise with such an identifier is found, this class is considered the expertise class for this weapon.

Мод предназначен для расширения механики прокачки пилота. Пилот может получать абстрактный опыт, но и специфический опыт связанный к конкретными действиями.
В частности со стрельбой из оружия. 
Можно определить "экспертизы" - сущности в в которых пилот накапливает опыт

Эти сущности описываются в кастомном ресурсе типа PilotWeaponLevelingDef

{
  "Description": {                                     - стандартное описание тут никаких особенностей нет, кроме того, что UIName должно быть задано обязательно
	                                                       в пользовательском интерфейсе будет использоваться именно оно, если оно не задано Name использоваться НЕ БУДЕТ
																												 и вы получите пустые строки в интерфейсе
    "UIName": "Ballistic",
    "Id": "pilotweaponlevelingdef_Ballistic",
    "Name": "ballistic leveling",
    "Details": "Ballistic Leveling",
    "Icon": "weapon_omni"
  },
  "HeaderChar": "B",                                  - Должен быть только один символ, используется когда необходимо показать данные об экспертизе в максимально краткой форме
  "Color":"#CCCC00",                                  - цвет для текста, в тек местах интерфейса, где это уместно будет использоваться данный цвет для текста
  "levels": [                                         - перечень уровней, который может быть достигнут в данном классе. 
	{
  	  "experience": 0,                                - количество опыта для достижения данного уровня
	  "Color": "yellow",                                - цвет для текста, в тек местах интерфейса, где это уместно будет использоваться данный цвет для текста
	  "HeaderChar": "0",                                - Должен быть только один символ, используется когда необходимо показать данные об уровне в максимально краткой форме
	  "progression": [                                  - информация о том сколько опыта пилот будет получать при стрельбе из оружия при данном уровне опыта
	  	  { 
					"chance": 0,                                - шанс на попадание
					"fail_exp": 10,                             - количество опыта при промахе
					"success_exp":20                            - количество опыта при попадании
				},
	  	  { "chance": 0.25, "fail_exp": 8, "success_exp":16 },
	  	  { "chance": 0.50, "fail_exp": 6, "success_exp":12 },
	  	  { "chance": 0.75, "fail_exp": 4, "success_exp":8 },
				
				Заметка:
				Работает это так - после атаки данным типом оружия (не выстрела а именно атаки, пушки делающие много бросков на попадание за залп не имеют преимуществ), 
				производится поиск в данном массиве записи с chance с наибольшим значением, но меньшим чем текущий эффективный шанс на попадание из данного оружия.
				Вычисляется доля попавших куда-либо пуль (неважно в ту цель в которую целелись или нет), без учета урона по площади (который всегда попадает)
				По доле попавших пуль вычисляется точка между "количество опыта при промахе" и "количество опыта при попадании" и это количество опыта добавляется пилоту в данном классе "экспертизы"
				Например: вы стреляете из ротарной LBX5 в режиме x3, с шансом 53%. По таблице ваша запись "chance": 0.50, "fail_exp": 6, "success_exp":12
				Всего вылетело 5x3 = 15 пуль, предположим попало из них 10. Пилот получит очков опыта (12 - 6) * (10/15) + 6 = 10 очков опыта. 
				При достижения количества опыта для определнного уровня, реальное применение бонусов будет произведено только в следующей битве, однако начиление очков опыта будет производится 
				в соотвествии с правилами уже нового уровня, это не ошибка, это сделано так специально. 
				Концептуальная идея разработчика о балансе прокачки состоит в том, что при низких уровнях опытности пилот должен получать достаточное количество опыта даже при промахах, 
				однако на высоких уровнях и при высоких шансах на попадание количество получаемого опыта должно снижаться - должно быть легко прокачаться до какого-то среднего уровня владения,
				дальнейший же прогресс должен быть существенно замедлен. 
	  ],
	  "levelDef":"" - идентификатор UpgradeDef компонента, который служит контейнером для бонусов предоставляемых данным уровнем владения оружием. Может быть пустым.
		                Хорошей идеей было бы создание компонента с дабафами для низких уровней владения оружием. 
										При инициализации юнита ему будет добавлен компонент данного типа в локацию 0 (None) т.е. компонент будет фактически не разрушим 
										Единственная особенность - способности добавляемые компонентом будут добавлены как способности пилота, а не в панель вооружения 
										как это делается для обычных компонентов добавляющих способности.
    },
	{
  	  "experience": 1000,
	  "Color": "green",
	  "HeaderChar": "1",
	  "progression": [
	  	  { "chance": 0, "fail_exp": 8, "success_exp":16 },
	  	  { "chance": 0.25, "fail_exp": 6, "success_exp":12 },
	  	  { "chance": 0.50, "fail_exp": 4, "success_exp":8 },
	  	  { "chance": 0.75, "fail_exp": 2, "success_exp":4 },
	  ],
	  "levelDef":"weaponleveldef_Ballistic_1"
    }
  ]
}

Особенности пользовательского интерфейса:

В кратком виде опыт плота отображается вместо строки экспертизы пилота (новобранец, ветеран и т.д.) теперь эта строка заменена на 
строку вида "<экспертиза1.HeaderChar><уровень.HeaderChar> <экспертиза2.HeaderChar><уровень.HeaderChar> ..."\

Настройки мода 

	"defaultGenerator":{   - генератор уровня опытности по умолчанию, см. раздел Генераторы уровня опытности
		"id":"default", "experience_min": 0, "experience_max": 2000, "experience_cap_min":1000, "experience_cap_max": 4000
	},
	"ChangedChar":"^",     - этот символ будет добавлен в начале строки экспертизы, если уровень опытности пилота изменился
	"ChangedCharColor":"yellow", - цвет вышеуказанного символа
	"ChangedColor":"#C1FF33FF",  - цвет, которым будет мигать фон строки экспертизы, если уровень опытности пилота изменился
	"LevelingBackColor":"#3366FF", - цвет фона элемента интерфейса представляющего класс опытности
	"LevelNotSelectedBackColor":"#808080", - цвет фона элемента интерфейса представляющего уровень опытности, если уровень не является текущим для пилота
	"LevelSelectedBackColor":"#008000" - цвет фона элемента интерфейса представляющего уровень опытности, если уровень является текущим для пилота
	
	
Генераторы опытности

уровень оптыности для пилота можно задать в json-файле PilotDef в разделе

"WeaponsProgression" : {
	"progression": {
		"pilotweaponlevelingdef_Ballistic": - идентификатор экспертизы
		{
			"experience": 234, - уровень опыта
			"experience_cap": 2000 - максимальный уровень опыта
		}
	}
}

Если у пилота отсутствует определение уровня опытности в каком-то классе экспертизы или если пилот сгенерирован случайным образом
текущий уровень опыта и максимальный уровень будут сгенерированны случайным образом. 
Для контроля этого процесса имеется возможность создать т.к.н. генераторы
Генератор сущность описываемая кастомным классом WeaponProgressionGenerator
{
	"id": "generator",  - идентификатор
	"experience_min": 0, - минимальный уровень опыта
	"experience_max": 2000, - максимальный уровень опыта
	"experience_cap_min": 0, - минимальный уровень лимита опыта
	"experience_cap_max": 2000, - максимальный уровень лимита опыта
	"systemTags": [], - тэги системы
	"pilotTags": [], - тэги пилота
	"levelings": [] - перечень класов экспертизы
}
Если пилоту необходимо сгенерировать экспертизу в каком-либо классе производится поиск среди всех доступных генераторов
По следующим криетриям
1. Если у генератора systemTags не пустой и контекст звездной системы имеет смысл, то система должна обладать всеми тегами указанными в определении генератора
2. Если у генератора pilotTags не пустой - пилот должен обладать всеми тегами указанными в определении генератора
3. Если у генератора levelings не пустой - идентификатор класса экспертизы должен присутствовать в перечне levelings

Если все эти три условия выполняются - генератор считается подходящим - выбирается первый подходящий генератор, генераторы сортируются непредсказуемым образом, 
по этому хорошей идеей будет определять непересекающиеся генераторы. Генератор с пустыми systemTags, pilotTags и levelings будет считаться подходящим во всех случаях.
Если подходящий генератор не был найден будет использоваться генератор определенный в defaultGenerator настроек мода. 

Связь оружия и класса экспертизы

У каждого оружия может быть только один класс экспертизы. Он определяется следующим образом - среди тегов оружия производится поиск тега 
с названием "progression_type_<суффикс идентификатор экспертизы>", если такой тег найден производится поиск класса экспертизы с идентификатором "pilotweaponlevelingdef_<суффикс идентификатор экспертизы>" 
Если экспертиза с таким идентификатором найдена - этот класс считается классом экспертизы для данного оружия.
Если поиск по тегам не дал результата - производится поиск класса экспертизы по категории оружия.
Производится поиск класса экспертиза с идентификатором "pilotweaponlevelingdef_<категория оружия>".
Если экспертиза с таким идентификатором найдена - этот класс считается классом экспертизы для данного оружия.


