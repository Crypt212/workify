<div class="skill-input space-y-4" id="skillInserter">
    <!-- Hidden input that will store our skills array -->
    <input type="hidden" name="skills" id="skillsInput" value="{{ json_encode(old('skills', $skills ?? [])) }}">

    <!-- Display area for added skills -->
    <div id="skillsContainer" class="flex flex-wrap">
        @if(old('skills', $skills ?? []))
            @foreach(json_decode(old('skills', json_encode($skills ?? [])), true) as $index => $skill)
                <div class="skill-item border ml-3 mb-3 flex text-blue-500 border-blue-500 items-center justify-between px-1 py-1 bg-gray-50 rounded-md">
                    <div class="flex">
                        <span class="font-medium">{{ $skill['name'] }}</span>
                        <span class="ml-2 px-2 py-1 text-xs rounded-full
                                     @if($skill['pivot']['proficiency'] === 'beginner') bg-blue-100 text-blue-800
                                     @elseif($skill['pivot']['proficiency'] === 'intermediate') bg-green-100 text-green-800
                                     @elseif($skill['pivot']['proficiency'] === 'advanced') bg-yellow-100 text-yellow-800
                            @else bg-purple-100 text-purple-800
                            @endif">
                            {{ ucfirst($skill['pivot']['proficiency']) }}
                        </span>
                    </div>
                    <button type="button" onclick="removeSkill({{ $index }})" class="text-red-500 hover:text-red-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            @endforeach
        @endif
    </div>

    <!-- Input for new skills -->
    <div class="flex space-x-2">
        <div class="flex-1">
            <input
                type="text"
                id="skillName"
                placeholder="Skill name"
                class="w-full px-3 py-2 border rounded-md"
            >
        </div>
        <div class="w-32">
            <select id="skillProficiency" class="w-full px-3 py-2 border rounded-md">
                <option value="beginner">Beginner</option>
                <option value="intermediate">Intermediate</option>
                <option value="advanced">Advanced</option>
                <option value="expert">Expert</option>
            </select>
        </div>
        <button
            type="button"
            id="addSkillBtn"
            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
            onclick="addSkill()"
        >
            Add
        </button>
    </div>
</div>

<script>
// Initialize skills array
    let skills = [];
    let childs = document.getElementById('skillsContainer').children;
    for (let i = 0; i < childs.length; i++) {
        name = childs[i].children[0].children[0].textContent.trim();
        proficiency = childs[i].children[0].children[1].textContent.trim();
        skills.push({ name, proficiency });
    }
    console.log(skills);
    console.log(document.getElementById('skillsInput'));

// Update the hidden input
function updateSkillsInput() {
    document.getElementById('skillsInput').value = JSON.stringify(skills);
}

// Add new skill
function addSkill() {
    const name = document.getElementById('skillName').value.trim();
    const proficiency = document.getElementById('skillProficiency').value;

    if (name) {
        if (skills.some(skill => skill.name.toLowerCase() == name.toLowerCase())) return;
        skills.push({ name, proficiency });
        renderSkills();
        document.getElementById('skillName').value = '';
        document.getElementById('skillName').focus();
    }
}

// Remove skill
function removeSkill(index) {
    console.log(index);
    skills.splice(index, 1);
    renderSkills();
}

// Render all skills
function renderSkills() {
    const container = document.getElementById('skillsContainer');
    container.innerHTML = skills.map((skill, index) => `
        <div class="skill-item border ml-3 flex text-blue-500 border-blue-500 items-center justify-between px-1 py-1 bg-gray-50 rounded-md">
            <div>
                <span class="font-medium">${skill.name}</span>
                <span class="ml-2 px-2 py-1 text-xs rounded-full
                    ${skill.proficiency === 'beginner' ? 'bg-blue-100 text-blue-800' :
                      skill.proficiency === 'intermediate' ? 'bg-green-100 text-green-800' :
                      skill.proficiency === 'advanced' ? 'bg-yellow-100 text-yellow-800' :
                      'bg-purple-100 text-purple-800'}">
                    ${skill.proficiency.charAt(0).toUpperCase() + skill.proficiency.slice(1)}
                </span>
            </div>
            <button type="button" onclick="removeSkill(${index})" class="text-red-500 hover:text-red-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    `).join('');

    updateSkillsInput();
}

// Add event listener for Enter key
document.getElementById('skillName').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        addSkill();
    }
});

// Initial render if there are existing skills
if (skills.length > 0) {
    renderSkills();
}
</script>
